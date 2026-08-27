<?php

namespace App\Controller\Agency;

use App\Entity\MarketplaceBooking;
use App\Services\BookingService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/agency/bookings")
 */
class BookingController extends AbstractAgencyController
{
    /**
     * @Route("/", name="agency_bookings")
     */
    public function indexAction(Request $request)
    {
        $agency = $this->getCurrentAgency();

        $status = $request->query->get('status');
        if ($status && !\in_array($status, MarketplaceBooking::getStatuses(), true)) {
            $status = null;
        }

        $bookings = $this->getDoctrine()->getRepository(MarketplaceBooking::class)
            ->findForAgency($agency, $status);

        return $this->render('agency/bookings/index.html.twig', [
            'agency' => $agency,
            'bookings' => $bookings,
            'statuses' => MarketplaceBooking::getStatuses(),
            'currentStatus' => $status,
        ]);
    }

    /**
     * @Route("/{id}/confirm", name="agency_booking_confirm", methods={"POST"})
     */
    public function confirmAction(Request $request, MarketplaceBooking $booking, BookingService $bookingService)
    {
        $this->denyAccessUnlessGranted('BOOKING_MANAGE', $booking);

        if (!$this->isCsrfTokenValid('booking_confirm_' . $booking->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        try {
            $bookingService->confirm($booking);
            $this->addFlash('success', 'Réservation confirmée.');
        } catch (\InvalidArgumentException $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('agency_bookings');
    }

    /**
     * @Route("/{id}/reject", name="agency_booking_reject", methods={"POST"})
     */
    public function rejectAction(Request $request, MarketplaceBooking $booking, BookingService $bookingService)
    {
        $this->denyAccessUnlessGranted('BOOKING_MANAGE', $booking);

        if (!$this->isCsrfTokenValid('booking_reject_' . $booking->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        try {
            $bookingService->reject($booking);
            $this->addFlash('success', 'Réservation refusée.');
        } catch (\InvalidArgumentException $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('agency_bookings');
    }
}
