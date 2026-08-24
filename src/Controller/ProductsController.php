<?php

namespace App\Controller;

use App\Entity\AppSettings;
use App\Entity\Destination;
use App\Entity\Message;
use App\Entity\Product;
use App\Form\BookingRequestType;
use App\Services\BookingService;
use App\Services\SearchService;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ProductsController extends AbstractController
{
    private SearchService $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * @Route("/search", name="all_products_list")
     */
    public function searchAction(Request $request, PaginatorInterface $paginator)
    {
        $search = $this->searchService->search($request);
        $pagination = $paginator->paginate(
            $search['query'], /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/
        );
        // replace this example code with whatever you need
        return $this->render('front/default/products.html.twig', [
            "products" => $pagination,
            "category" => $search['category'],
            "destination" => $search['destination'],
            "criteria" => $search['criteria'],
            "q" => $search['criteria']['q'],
            "page"=>null
        ]);
    }

    /**
     * @Route("/excursions.html", name="excursions_products_list")
     */
    public function excursionsAction(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $search = $this->searchService->search($request, ['category' => 1]);

        $pagination = $paginator->paginate(
            $search['query'], /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/
        );
        return $this->render('front/default/products.html.twig', [
            "products" => $pagination,
            'category'=>$search['category'],
            'destination'=>$search['destination'],
            'criteria'=>$search['criteria'],
            "page" => $em->getRepository("App\Entity\Page")->find(3),
        ]);
    }


    /**
     * @Route("/circuits.html", name="circuits_products_list")
     */
    public function circuitsAction(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $search = $this->searchService->search($request, ['category' => 1]);

        $pagination = $paginator->paginate(
            $search['query'], /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/
        );
        return $this->render('front/default/products.html.twig', [
            "products" => $pagination,
            'category'=>$search['category'],
            'destination'=>$search['destination'],
            'criteria'=>$search['criteria'],
            "page" => $em->getRepository("App\Entity\Page")->find(2),
        ]);
    }




    /**
     * @Route("/{category}/{id}-{slug}.html", name="product_details")
     */
    public function detailsAction(Request $request,Product $product)
    {
        if ($product->getStatus() !== Product::STATUS_PUBLISHED
            && !$this->isGranted('EXCURSION_VIEW', $product)
        ) {
            throw $this->createNotFoundException('Excursion not found.');
        }

        $message = new Message();
        $form_message = $this->createForm('App\Form\MessageType', $message,array(
            'action' => $this->generateUrl('product_book_request',array("id"=>$product->getProductId())),
            'method' => 'POST',
        ));

        $bookingForm = $this->createForm(BookingRequestType::class, null, [
            'product' => $product,
            'action' => $this->generateUrl('excursion_booking_request', ['id' => $product->getProductId()]),
            'method' => 'POST',
        ]);

        $similarExcursions = [];
        if ($product->getCategory()) {
            $similarExcursions = $this->getDoctrine()->getManager()->createQueryBuilder()
                ->select('p')
                ->from(Product::class, 'p')
                ->andWhere('p.category = :category')
                ->andWhere('p.status = :status')
                ->andWhere('p.productId != :id')
                ->setParameter('category', $product->getCategory())
                ->setParameter('status', Product::STATUS_PUBLISHED)
                ->setParameter('id', $product->getProductId())
                ->setMaxResults(4)
                ->getQuery()
                ->getResult();
        }

        // replace this example code with whatever you need
        return $this->render('front/default/details.html.twig', [
            "product" => $product,
            'form' => $form_message->createView(),
            'bookingForm' => $bookingForm->createView(),
            'similarExcursions' => $similarExcursions,
        ]);
    }

    /**
     * @Route("/excursions/{id}/reserver", name="excursion_booking_request", requirements={"id"="\d+"})
     */
    public function bookRequestAction(Request $request, Product $product, BookingService $bookingService, \App\Services\RoutingService $routingService)
    {
        if ($product->getStatus() !== Product::STATUS_PUBLISHED) {
            throw $this->createNotFoundException('Excursion not found.');
        }

        $form = $this->createForm(BookingRequestType::class, null, ['product' => $product]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $schedule = $data['schedule'] ?? null;
            $date = $data['date'] ?? ($schedule ? $schedule->getDate() : new \DateTime());

            try {
                $booking = $bookingService->createBookingRequest(
                    $product,
                    $schedule,
                    $date,
                    (int) $data['adults'],
                    (int) ($data['children'] ?? 0),
                    $data['customerName'],
                    $data['customerPhone'],
                    $data['customerEmail'],
                    $data['comments'] ?? null,
                    $this->getUser()
                );
                $this->addFlash('success', sprintf('Votre demande de réservation a été envoyée. Référence : %s', $booking->getReference()));
            } catch (\InvalidArgumentException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        } else {
            $this->addFlash('error', 'Veuillez vérifier les informations saisies.');
        }

        return $this->redirect($routingService->getUrl($product));
    }




    /**
     * @Route("/product/contact/request/{id}", name="product_book_request")
     */
    public function formQuoteAction(Request $request,Product $product, MailerInterface $mailer, \App\Services\RoutingService $routingService)
    {
        $message = new Message();
        $form_message = $this->createForm('App\Form\MessageType', $message,array(
            'action' => $this->generateUrl('product_book_request',array("id"=>$product->getProductId())),
            'method' => 'POST',
        ));
        $form_message->handleRequest($request);

        if ($form_message->isSubmitted() && $form_message->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $message->setProduct($product);
            $em->persist($message);
            $em->flush($message);
            $this->sendMessage($message, $mailer);
        }
        $request->getSession()->getFlashBag()->add('success', true);
        return $this->redirect($routingService->getUrl($product));
    }

    public function sendMessage(Message $message, MailerInterface $mailer){
        $settings = $this->getDoctrine()->getRepository(AppSettings::class)->findAll();
        $settingsObject = new \stdClass();
        foreach ($settings as $setting){
            $settingsObject->{$setting->getKey()} = $setting->getValue();
        }
        $content =  $this->renderView(
        // templates/emails/registration.html.twig
            '@App/emails/email.html.twig',
            array('message' => $message)
        );
        $email = (new Email())
            ->subject('Product form')
            ->from($message->getEmail())
            ->to($settingsObject->application_email ?? '')
            ->html($content);
        $mailer->send($email);
    }


    public function destination(Request $request,$name){

        $em = $this->getDoctrine();
        /** @var Destination $destination */
        $destination = $em->getRepository("App\Entity\Destination")->findOneBy(array("destinationName"=>$name));

        if (!$destination) {
            throw $this->createNotFoundException('Destination not found.');
        }

        $search = $this->searchService->search($request, ['destination' => $destination->getDestinationId()]);
        $pagination = $this->get('knp_paginator')->paginate(
            $search['query'], /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/
        );
        // replace this example code with whatever you need
        return $this->render('front/default/products.html.twig', [
            "products" => $pagination,
            "category" => $search['category'],
            "destination" => $destination,
            "criteria" => $search['criteria'],
            "q" => $search['criteria']['q'],
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
