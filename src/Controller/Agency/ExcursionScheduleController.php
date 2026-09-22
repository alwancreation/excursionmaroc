<?php

namespace App\Controller\Agency;

use App\Entity\ExcursionSchedule;
use App\Entity\Product;
use App\Form\ExcursionScheduleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/agency/excursions/{id}/schedules")
 */
class ExcursionScheduleController extends AbstractAgencyController
{
    /**
     * @Route("/", name="agency_excursion_schedules")
     */
    public function indexAction(Request $request, Product $excursion)
    {
        $this->denyAccessUnlessGranted('EXCURSION_MANAGE', $excursion);

        $schedule = new ExcursionSchedule();
        $schedule->setProduct($excursion);

        $form = $this->createForm(ExcursionScheduleType::class, $schedule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $schedule->setRemainingCapacity($schedule->getCapacity());
            $schedule->setStatus(ExcursionSchedule::STATUS_OPEN);

            $em = $this->getDoctrine()->getManager();
            $em->persist($schedule);
            $em->flush();

            return $this->redirectToRoute('agency_excursion_schedules', ['id' => $excursion->getProductId()]);
        }

        return $this->render('agency/excursions/schedules.html.twig', [
            'excursion' => $excursion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{scheduleId}/delete", name="agency_excursion_schedule_delete", methods={"POST"})
     */
    public function deleteAction(Request $request, Product $excursion, int $scheduleId)
    {
        $this->denyAccessUnlessGranted('EXCURSION_MANAGE', $excursion);

        if (!$this->isCsrfTokenValid('excursion_schedule_delete_' . $scheduleId, $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        $em = $this->getDoctrine()->getManager();
        $schedule = $em->getRepository(ExcursionSchedule::class)->find($scheduleId);

        if ($schedule && $schedule->getProduct() === $excursion) {
            $em->remove($schedule);
            $em->flush();
        }

        return $this->redirectToRoute('agency_excursion_schedules', ['id' => $excursion->getProductId()]);
    }
}
