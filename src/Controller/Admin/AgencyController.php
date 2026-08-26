<?php

namespace App\Controller\Admin;

use App\Entity\Agency;
use App\Services\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/agencies")
 */
class AgencyController extends AbstractController
{
    /**
     * @Route("/", name="admin_agency_index", methods={"GET"})
     */
    public function index(): Response
    {
        $agencies = $this->getDoctrine()->getRepository(Agency::class)
            ->findBy([], ['dateCreate' => 'DESC']);

        return $this->render('admin/agency/index.html.twig', [
            'agencies' => $agencies,
        ]);
    }

    /**
     * @Route("/{id}/approve", name="admin_agency_approve", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function approve(Request $request, Agency $agency, NotificationService $notificationService): Response
    {
        if ($this->isCsrfTokenValid('agency_approve' . $agency->getId(), $request->request->get('_token'))) {
            $wasValid = $agency->isValid();
            $agency->setValid(true);
            $this->getDoctrine()->getManager()->flush();

            if (!$wasValid) {
                $notificationService->notifyAgencyAccountApproved($agency);
            }
            $this->addFlash('success', 'Agence validée.');
        }

        return $this->redirectToRoute('admin_agency_index');
    }

    /**
     * @Route("/{id}/suspend", name="admin_agency_suspend", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function suspend(Request $request, Agency $agency): Response
    {
        if ($this->isCsrfTokenValid('agency_suspend' . $agency->getId(), $request->request->get('_token'))) {
            $agency->setValid(false);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Agence suspendue.');
        }

        return $this->redirectToRoute('admin_agency_index');
    }

    /**
     * @Route("/{id}/verify", name="admin_agency_verify", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function verify(Request $request, Agency $agency): Response
    {
        if ($this->isCsrfTokenValid('agency_verify' . $agency->getId(), $request->request->get('_token'))) {
            $agency->setVerified(true);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Agence marquée comme vérifiée.');
        }

        return $this->redirectToRoute('admin_agency_index');
    }

    /**
     * @Route("/{id}/unverify", name="admin_agency_unverify", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function unverify(Request $request, Agency $agency): Response
    {
        if ($this->isCsrfTokenValid('agency_unverify' . $agency->getId(), $request->request->get('_token'))) {
            $agency->setVerified(false);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Statut vérifié retiré.');
        }

        return $this->redirectToRoute('admin_agency_index');
    }
}
