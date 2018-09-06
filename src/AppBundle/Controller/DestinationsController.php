<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DestinationsController extends Controller
{
    /**
     * @Route("/destinations.html", name="destinations_index")
     */
    public function indexAction(Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('AppBundle:destinations:index.html.twig', [

        ]);
    }
}
