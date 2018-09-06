<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Destination;
use AppBundle\Entity\Message;
use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductsController extends Controller
{

    /**
     * @Route("/search", name="all_products_list")
     */
    public function searchAction(Request $request)
    {
        $search = $this->searchFunction($request);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $search['query'], /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/
        );
        // replace this example code with whatever you need
        return $this->render('AppBundle:default:products.html.twig', [
            "products" => $pagination,
            "category" => $search['category'],
            "destination" => $search['destination'],
            "q" => $search['q'],
            "page"=>null
        ]);
    }

    public function searchFunction(Request $request){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT p FROM AppBundle:Product p";

        $cid = $request->query->get('cid',0);
        $q = $request->query->get('q','');

        $category = $em->getRepository("AppBundle:Category")->find($cid);
        $where = ' where ';
        $and = ' ';
        if ($category){
            $dql   .= $where.$and." p.category=:category";
            $where = '';
            $and= ' and ';
        }

        $destination = $request->query->get('destination',0);
        $destination = $em->getRepository("AppBundle:Destination")->find($destination);
        if ($destination){
            $dql   .= $where.$and." p.destination=:destination";
            $where = '';
            $and= ' and ';
        }

        if ($q!=''){
            $dql   .= $where.$and." (p.productName like :query)";
        }
        $query = $em->createQuery($dql);
        if ($destination){
            $query = $query->setParameter("destination",$destination);
        }
        if ($category){
            $query = $query->setParameter("category",$category);
        }
        if ($q!=''){
            $query = $query->setParameter("query","%".$q."%");
        }
        return array(
            'q'        =>$q,
            'query'        =>$query,
            'category'     =>$category,
            'destination'  =>$destination
        );
    }

    /**
     * @Route("/excursions.html", name="excursions_products_list")
     */
    public function excursionsAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("AppBundle:Category")->find(2);
        $dql   = "SELECT p FROM AppBundle:Product p where p.category=:category";
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
        return $this->render('AppBundle:default:products.html.twig', [
            "products" => $pagination,
            'category'=>$category,
            "page" => $em->getRepository("AppBundle:Page")->find(3),
        ]);
    }


    /**
     * @Route("/circuits.html", name="circuits_products_list")
     */
    public function circuitsAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("AppBundle:Category")->find(1);
        $dql   = "SELECT p FROM AppBundle:Product p where p.category=:category";
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
        return $this->render('AppBundle:default:products.html.twig', [
            "products" => $pagination,
            'category'=>$category,
            "page" => $em->getRepository("AppBundle:Page")->find(2),
        ]);
    }




    /**
     * @Route("/{category}/{id}-{slug}.html", name="product_details")
     */
    public function detailsAction(Request $request,Product $product)
    {
        $message = new Message();
        $form_message = $this->createForm('AppBundle\Form\MessageType', $message,array(
            'action' => $this->generateUrl('product_book_request',array("id"=>$product->getProductId())),
            'method' => 'POST',
        ));
        // replace this example code with whatever you need
        return $this->render('AppBundle:default:details.html.twig', [
            "product" => $product,
            'form' => $form_message->createView(),
        ]);
    }




    /**
     * @Route("/product/contact/request/{id}", name="product_book_request")
     */
    public function formQuoteAction(Request $request,Product $product)
    {
        $message = new Message();
        $form_message = $this->createForm('AppBundle\Form\MessageType', $message,array(
            'action' => $this->generateUrl('product_book_request',array("id"=>$product->getProductId())),
            'method' => 'POST',
        ));
        $form_message->handleRequest($request);

        if ($form_message->isSubmitted() && $form_message->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $message->setProduct($product);
            $em->persist($message);
            $em->flush($message);
            $this->sendMessage($message);
        }
        $request->getSession()->getFlashBag()->add('success', true);
        return $this->redirect($this->get('routing_service')->getUrl($product));
    }

    public function sendMessage(Message $message){
        $mailer = $this->get('mailer');
        $settings = $this->getDoctrine()->getRepository('AppBundle:Settings')->findAll();
        $settingsObject = new \stdClass();
        foreach ($settings as $setting){
            $settingsObject->{$setting->getSettingKey()} = $setting->getSettingValue();
        }
        $content =  $this->renderView(
        // templates/emails/registration.html.twig
            '@App/emails/email.html.twig',
            array('message' => $message)
        );
        $message = (new \Swift_Message('Product form'))
            ->setFrom($message->getEmail(),$message->getFirstName().' '.$message->getLastName())
            ->setTo($settingsObject->application_email,$settingsObject->application_name)
            ->setBody($content,'text/html')
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;
        $mailer->send($message);
    }


    public function destination(Request $request,$name){

        $em = $this->getDoctrine();
        /** @var Destination $destination */
        $destination = $em->getRepository("AppBundle:Destination")->findOneBy(array("destinationName"=>$name));

        $request->query->add(array('destination',$destination->getDestinationId()));
        $search = $this->searchFunction($request);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $search['query'], /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/
        );
        // replace this example code with whatever you need
        return $this->render('AppBundle:default:products.html.twig', [
            "products" => $pagination,
            "category" => $search['category'],
            "destination" => $destination,
            "q" => $search['q'],
            "page"=>null
        ]);

    }

    /**
     * @Route("/destinations/marrakech.html",name="destination_url_marrakech")
     */
    public function destination_url_marrakechAction(Request $request){return $this->destination($request,'marrakech');}

    /**
     * @Route("/destinations/casablanca.html",name="destination_url_casablanca")
     */
    public function destination_url_casablancaAction(Request $request){return $this->destination($request,'casablanca');}

    /**
     * @Route("/destinations/fes.html",name="destination_url_fes")
     */
    public function destination_url_fesAction(Request $request){return $this->destination($request,'fes');}

    /**
     * @Route("/destinations/essaouira.html",name="destination_url_essaouira")
     */
    public function destination_url_essaouiraAction(Request $request){return $this->destination($request,'essaouira');}

    /**
     * @Route("/destinations/chefchaouen.html",name="destination_url_chefchaouen")
     */
    public function destination_url_chefchaouenAction(Request $request){return $this->destination($request,'chefchaouen');}

    /**
     * @Route("/destinations/agadir.html",name="destination_url_agadir")
     */
    public function destination_url_agadirAction(Request $request){return $this->destination($request,'agadir');}

    /**
     * @Route("/destinations/sahara.html",name="destination_url_sahara")
     */
    public function destination_url_saharaAction(Request $request){return $this->destination($request,'sahara');}

    /**
     * @Route("/destinations/rabat.html",name="destination_url_rabat")
     */
    public function destination_url_rabatAction(Request $request){return $this->destination($request,'rabat');}

    /**
     * @Route("/destinations/ouarzazate.html",name="destination_url_ouarzazate")
     */
    public function destination_url_ouarzazateAction(Request $request){return $this->destination($request,'ouarzazate');}

    /**
     * @Route("/destinations/tetouan.html",name="destination_url_tetouan")
     */
    public function destination_url_tetouanAction(Request $request){return $this->destination($request,'tetouan');}

    /**
     * @Route("/destinations/eljadida.html",name="destination_url_eljadida")
     */
    public function destination_url_eljadidaAction(Request $request){return $this->destination($request,'el jadida');}

    /**
     * @Route("/destinations/montages.html",name="destination_url_montages")
     */
    public function destination_url_montagesAction(Request $request){return $this->destination($request,'montages');}



}
