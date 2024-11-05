<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DestinationsController extends AbstractController
{
    /**
     * @Route("/destinations.html", name="destinations_index")
     */
    public function indexAction(Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('front/destinations/index.html.twig', [

        ]);
    }
}
