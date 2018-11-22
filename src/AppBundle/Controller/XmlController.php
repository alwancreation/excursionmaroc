<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class
 * @Route("xml")
 */
class XmlController extends Controller
{
    /**
     * @Route("/site-map.xml", name="xml_sitmap_all")
     */
    public function mapAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // $companies = $em->getRepository('AppBundle:Company')->findAll();
        // replace this example code with whatever you need
        return $this->render('AppBundle:xml:map.html.twig', [
            
        ]);
    }

    /**
     * @Route("/xml-agencies.xml", name="xml_sitmap")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $agencies = $em->getRepository('AppBundle:Agency')->findAll();
        // replace this example code with whatever you need
        return $this->render('AppBundle:xml:xml-agencies.html.twig', [
            "agencies"=>$agencies
        ]);
    }

    /**
     * @Route("/programmes.xml", name="xml_programmes_sitmap")
     */
    public function programmesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('AppBundle:Product')->findAll();
        return $this->render('AppBundle:xml:xml-programmes.html.twig', [
            "products" => $products
        ]);
    }
}