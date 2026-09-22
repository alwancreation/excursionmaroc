<?php

namespace App\Controller\Agency;

use App\Entity\ExcursionItinerary;
use App\Entity\Product;
use App\Form\ExcursionItineraryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/agency/excursions/{id}/itinerary")
 */
class ExcursionItineraryController extends AbstractAgencyController
{
    /**
     * @Route("/", name="agency_excursion_itinerary")
     */
    public function indexAction(Request $request, Product $excursion)
    {
        $this->denyAccessUnlessGranted('EXCURSION_MANAGE', $excursion);

        $step = new ExcursionItinerary();
        $step->setProduct($excursion);
        $step->setPosition($excursion->getItinerarySteps()->count());

        $form = $this->createForm(ExcursionItineraryType::class, $step);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($step);
            $em->flush();

            return $this->redirectToRoute('agency_excursion_itinerary', ['id' => $excursion->getProductId()]);
        }

        return $this->render('agency/excursions/itinerary.html.twig', [
            'excursion' => $excursion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{stepId}/delete", name="agency_excursion_itinerary_delete", methods={"POST"})
     */
    public function deleteAction(Request $request, Product $excursion, int $stepId)
    {
        $this->denyAccessUnlessGranted('EXCURSION_MANAGE', $excursion);

        if (!$this->isCsrfTokenValid('excursion_step_delete_' . $stepId, $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        $em = $this->getDoctrine()->getManager();
        $step = $em->getRepository(ExcursionItinerary::class)->find($stepId);

        if ($step && $step->getProduct() === $excursion) {
            $em->remove($step);
            $em->flush();
        }

        return $this->redirectToRoute('agency_excursion_itinerary', ['id' => $excursion->getProductId()]);
    }
}
