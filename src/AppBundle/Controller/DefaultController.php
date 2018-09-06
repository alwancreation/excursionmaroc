<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('AppBundle:Page')->find(1);

        $homeSlide = $em->getRepository('AppBundle:Slider')->find(1);
        $message = new Message();
        $form_message = $this->createForm('AppBundle\Form\MessageType', $message,array(
            'action' => $this->generateUrl('transfers_quote_request'),
            'method' => 'POST',
        ));
        // replace this example code with whatever you need
        return $this->render('AppBundle:default:index.html.twig', [
            "page" => $page,
            "homeSlide" => $homeSlide,
            'form_message' => $form_message->createView(),
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:default:contact.html.twig', [

        ]);
    }

    /**
     * @Route("/quote.html", name="free_quote")
     */
    public function quoteAction(Request $request)
    {
        $message = new Message();
        $form_message = $this->createForm('AppBundle\Form\MessageType', $message,array(
            'action' => $this->generateUrl('transfers_quote_request'),
            'method' => 'POST',
        ));

        // replace this example code with whatever you need
        return $this->render('AppBundle:default:quote.html.twig', [
            'form_message' => $form_message->createView(),
        ]);
    }



}
