<?php

namespace App\Controller\Agency;

use App\Entity\Product;
use App\Form\ExcursionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/agency/excursions")
 */
class ExcursionController extends AbstractAgencyController
{
    /**
     * @Route("/", name="agency_excursions")
     */
    public function listAction()
    {
        $agency = $this->getCurrentAgency();

        return $this->render('agency/excursions/index.html.twig', [
            'agency' => $agency,
            'excursions' => $agency->getProducts(),
        ]);
    }

    /**
     * @Route("/new", name="agency_excursion_new")
     */
    public function newAction(Request $request)
    {
        $agency = $this->getCurrentAgency();

        $product = new Product();
        $product->setAgency($agency);
        $product->setStatus(Product::STATUS_DRAFT);

        $form = $this->createForm(ExcursionType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Excursion créée en brouillon.');

            return $this->redirectToRoute('agency_excursion_edit', ['id' => $product->getProductId()]);
        }

        return $this->render('agency/excursions/form.html.twig', [
            'form' => $form->createView(),
            'excursion' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="agency_excursion_edit")
     */
    public function editAction(Request $request, Product $excursion)
    {
        $this->denyAccessUnlessGranted('EXCURSION_MANAGE', $excursion);

        $form = $this->createForm(ExcursionType::class, $excursion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Excursion mise à jour.');

            return $this->redirectToRoute('agency_excursion_edit', ['id' => $excursion->getProductId()]);
        }

        return $this->render('agency/excursions/form.html.twig', [
            'form' => $form->createView(),
            'excursion' => $excursion,
        ]);
    }

    /**
     * @Route("/{id}/submit", name="agency_excursion_submit", methods={"POST"})
     */
    public function submitForReviewAction(Request $request, Product $excursion)
    {
        $this->denyAccessUnlessGranted('EXCURSION_MANAGE', $excursion);

        if (!$this->isCsrfTokenValid('excursion_submit_' . $excursion->getProductId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        if (\in_array($excursion->getStatus(), [Product::STATUS_DRAFT, Product::STATUS_REJECTED], true)) {
            $excursion->setStatus(Product::STATUS_PENDING_REVIEW);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Excursion soumise pour validation.');
        }

        return $this->redirectToRoute('agency_excursion_edit', ['id' => $excursion->getProductId()]);
    }
}
