<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Page;
use App\Form\MessageType;
use App\Entity\Slider;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository(Page::class)->find(1);

        $homeSlide = $em->getRepository(Slider::class)->find(1);
        $message = new Message();
        $form_message = $this->createForm(MessageType::class, $message,array(
            'action' => $this->generateUrl('transfers_quote_request'),
            'method' => 'POST',
        ));
        // replace this example code with whatever you need
        return $this->render('front/default/index.html.twig', [
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
        return $this->render('front/default/contact.html.twig', [

        ]);
    }

    /**
     * @Route("/switch-language/{locale}", name="app_switch_language")
     */
    public function switchLanguageAction(Request $request, string $locale)
    {
        // Keep in sync with the app_languages Twig global in config/packages/twig.yaml
        $availableLocales = ['en', 'fr', 'de'];
        if (\in_array($locale, $availableLocales, true)) {
            $request->getSession()->set('_locale', $locale);
        }

        $referer = $request->headers->get('referer');
        if ($referer && parse_url($referer, PHP_URL_HOST) === $request->getHost()) {
            return $this->redirect($referer);
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/quote.html", name="free_quote")
     */
    public function quoteAction(Request $request)
    {
        $message = new Message();
        $form_message = $this->createForm('App\Form\MessageType', $message,array(
            'action' => $this->generateUrl('transfers_quote_request'),
            'method' => 'POST',
        ));

        // replace this example code with whatever you need
        return $this->render('front/default/quote.html.twig', [
            'form_message' => $form_message->createView(),
        ]);
    }



}
