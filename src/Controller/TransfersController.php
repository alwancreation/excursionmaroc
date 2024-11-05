<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class TransfersController extends AbstractController
{
    /**
     * @Route("/transfers.html", name="transfers_index")
     */
    public function indexAction(Request $request)
    {



        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("App:Category")->find(3);
        $dql   = "SELECT p FROM App:Product p where p.category=:category";
        $query = $em->createQuery($dql)
            ->setParameters(array(
                'category'=>$category
            ));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/
        );
        // replace this example code with whatever you need
        return $this->render('front/default/products.html.twig', [
            "products" => $pagination,
            'category'=>$category,
            "page" => $em->getRepository("App:Page")->find(4),
        ]);

    }

    /**
     * @Route("/transfers/quote/request", name="transfers_quote_request")
     */
    public function formQuoteAction(Request $request)
    {
        $message = new Message();
        $form_message = $this->createForm('App\Form\MessageType', $message,array(
            'action' => $this->generateUrl('transfers_quote_request'),
            'method' => 'POST',
        ));
        $form_message->handleRequest($request);

        if ($form_message->isSubmitted() && $form_message->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush($message);
            echo "Ok";
        }
        exit();
    }
}
