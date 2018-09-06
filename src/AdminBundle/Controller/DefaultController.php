<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        if($this->getUser()->hasRole('ROLE_MANAGER')){
            return $this->redirect($this->generateUrl('user_agency_index'));
        }
        return $this->redirect($this->generateUrl('pages_edit',['id'=>1]));

        return $this->render('AdminBundle:Default:index.html.twig',array(

        ));
    }
}
