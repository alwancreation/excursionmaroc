<?php

namespace App\Controller\Agency;

use App\Entity\Agency;
use App\Entity\UserAgency;
use App\Form\AgencyProfileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/agency")
 */
class AgencyController extends AbstractController
{
    /**
     * @Route("/dashboard", name="agency_dashboard")
     */
    public function dashboardAction()
    {
        $agency = $this->getCurrentAgency();

        return $this->render('agency/dashboard.html.twig', [
            'agency' => $agency,
        ]);
    }

    /**
     * @Route("/profile", name="agency_profile")
     */
    public function profileAction(Request $request)
    {
        $agency = $this->getCurrentAgency();
        $this->denyAccessUnlessGranted('AGENCY_MANAGE', $agency);

        $form = $this->createForm(AgencyProfileType::class, $agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if ($agency->getAssetFile()) {
                $file = $form->get('assetFile')->getData();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move('uploads/agencies', $fileName);
                $agency->setLogo($fileName);
                $agency->setAssetFile(null);
            }

            if ($agency->getCoverFile()) {
                $file = $form->get('coverFile')->getData();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move('uploads/agencies', $fileName);
                $agency->setCover($fileName);
                $agency->setCoverFile(null);
            }

            $em->flush();
            $this->addFlash('success', 'Profil agence mis à jour.');

            return $this->redirectToRoute('agency_profile');
        }

        return $this->render('agency/profile.html.twig', [
            'agency' => $agency,
            'form' => $form->createView(),
        ]);
    }

    private function getCurrentAgency(): Agency
    {
        $user = $this->getUser();
        $userAgency = $this->getDoctrine()->getRepository(UserAgency::class)->findOneBy(['user' => $user]);

        if (!$userAgency) {
            throw $this->createNotFoundException('Aucune agence associée à ce compte.');
        }

        $agency = $userAgency->getAgency();
        $this->denyAccessUnlessGranted('AGENCY_VIEW', $agency);

        return $agency;
    }
}
