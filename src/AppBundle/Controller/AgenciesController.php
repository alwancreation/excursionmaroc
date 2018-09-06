<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Agency;
use AppBundle\Entity\Product;
use AppBundle\Entity\User;
use AppBundle\Helper\Utils;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AgenciesController extends Controller
{
    /**
     * @Route("/agences.html", name="agencies_index")
     */
    public function indexAction(Request $request)
    {
        $agencies = $this->getDoctrine()->getRepository("AppBundle:Agency")->findBy(array("valid"=>true));
        $page = $this->getDoctrine()->getRepository("AppBundle:Page")->findOneBy(array("pageId"=>6));
        // replace this example code with whatever you need
        return $this->render('AppBundle:agencies:index.html.twig', [
            "agencies"=> $agencies,
            "page"=> $page,

        ]);
    }
    /**
     * @Route("/agencies/{slug}", name="front_agency_details")
     */
    public function detailsAction(Request $request,$slug)
    {
        $agency = $this->getDoctrine()->getRepository("AppBundle:Agency")->findOneBy(array("slug"=>$slug));
        // replace this example code with whatever you need
        return $this->render('AppBundle:agencies:details.html.twig', [
            "agency"=> $agency
        ]);
    }

    /**
     * @Route("/sign-in-agency", name="agency_sign_in")
     */
    public function signInAction(Request $request)
    {
        $agency = new Agency();
        $form_agency = $this->createForm('AppBundle\Form\AgencySignUpType', $agency,array(
            // 'action' => $this->generateUrl('transfers_quote_request'),
            'method' => 'POST',
        ));
        $form_agency->handleRequest($request);

        if ($form_agency->isSubmitted() && $form_agency->isValid()) {
            if ($agency->user_password==$agency->user_password_confirm){
                $utils = new Utils();
                $em = $this->getDoctrine()->getManager();
                $user = new User();
                $user->setUserFirstName($agency->user_first_name);
                $user->setUserLastName($agency->user_last_name);
                $user->setEmail($agency->user_email);
                $user->setUsername($agency->user_email);
                $user->setPlainPassword($agency->user_password);
                $user->setEnabled(true);
                $user->addRole("ROLE_MANAGER");
                $em->persist($user);
                $agency->setUser($user);
                $agency->setSlug($utils->slugify($agency->getName()));
                $em->persist($agency);
                $em->flush($agency);
                return $this->redirect($this->generateUrl("admin_default_index"));
            }
        }
        // replace this example code with whatever you need
        return $this->render('AppBundle:agencies:sign-in.html.twig', [
            "form"=>$form_agency->createView()
        ]);
    }
}
