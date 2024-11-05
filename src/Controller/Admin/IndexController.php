<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin")
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/", name="admin_index")
     */
    public function index(): Response
    {
        $latestBookings = $this->getDoctrine()->getRepository(Booking::class)->findLatest(10);

        return $this->render('admin/dashboard/index.html.twig', [
            'booking' => new Booking(),
            'latestBookings' => $latestBookings,
        ]);
    }
}
