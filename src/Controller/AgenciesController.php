<?php

namespace App\Controller;

use App\Entity\Agency;
use App\Entity\Product;
use App\Entity\User;
use App\Helper\Utils;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
class AgenciesController extends AbstractController
{
    /**
     * @Route("/agences-de-voyage-maroc", name="agencies_index")
     */
    public function indexAction(Request $request,PaginatorInterface $paginator)
    {
        $agencies = $this->getDoctrine()->getRepository("App\Entity\Agency")->findBy(array("valid"=>true));
        $page = $this->getDoctrine()->getRepository("App\Entity\Page")->findOneBy(array("pageId"=>6));

        $pagination = $paginator->paginate(
            $agencies, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

        // replace this example code with whatever you need
        return $this->render('front/agencies/index.html.twig', [
            "agencies"=> $pagination,
            "page"=> $page,

        ]);
    }
    /**
     * @Route("/agencies/{slug}", name="front_agency_details")
     */
    public function detailsAction(Request $request,$slug)
    {
        $agency = $this->getDoctrine()->getRepository("App:Agency")->findOneBy(array("slug"=>$slug));
        // replace this example code with whatever you need
        return $this->render('front/agencies/details.html.twig', [
            "agency"=> $agency
        ]);
    }

    /**
     * @Route("/sign-in-agency", name="agency_sign_in")
     */
    public function signInAction(Request $request)
    {
        $agency = new Agency();
        $form_agency = $this->createForm('App\Form\AgencySignUpType', $agency,array(
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
        return $this->render('front/agencies/sign-in.html.twig', [
            "form"=>$form_agency->createView()
        ]);
    }
}
