<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\Agency;
use AppBundle\Entity\UserAgency;
use AppBundle\Helper\ImageResize;
use AppBundle\Helper\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Agency controller.
 */
class AgencyController extends Controller
{
    /**
     * Lists all agency entities.
     *
     * @Route("/agencies/", name="agency_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $agencies = $em->getRepository('AppBundle:Agency')->findAllGranted($this->getUser());

        return $this->render('AdminBundle:agency:index.html.twig', array(
            'agencies' => $agencies,
        ));
    }

    /**
     * Lists all agency entities.
     *
     * @Route("/agency", name="user_agency_index")
     * @Method("GET")
     */
    public function agencyAction()
    {
        $em = $this->getDoctrine()->getManager();
        $agencies = $em->getRepository('AppBundle:Agency')->findAllGranted($this->getUser());
        return $this->render('AdminBundle:agency:home.html.twig', array(

        ));
    }

    /**
     * Creates a new agency entity.
     *
     * @Route("/agencies/new", name="agency_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $agency = new Agency();
        $form = $this->createForm('AppBundle\Form\AgencyType', $agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($agency->getAssetFile()){
                $utils = new Utils();
                $imageFileName = $utils->upload($agency->getAssetFile(), "uploads/agencies/");
                $agency->setLogo($imageFileName);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($agency);
            $em->flush();

            return $this->redirectToRoute('agency_index');
        }

        return $this->render('AdminBundle:agency:new.html.twig', array(
            'agency' => $agency,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a agency entity.
     *
     * @Route("/agencies/{id}", name="agency_show")
     * @Method("GET")
     */
    public function showAction(Agency $agency)
    {
        $deleteForm = $this->createDeleteForm($agency);
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository("AppBundle:User")->findBy(array("enabled"=>true));
        return $this->render('AdminBundle:agency:show.html.twig', array(
            'agency' => $agency,
            'users' => $users,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing agency entity.
     *
     * @Route("/agencies/{id}/edit", name="agency_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Agency $agency)
    {
        $deleteForm = $this->createDeleteForm($agency);
        $editForm = $this->createForm('AppBundle\Form\AgencyType', $agency);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ($agency->getAssetFile()){
                $utils = new Utils();
                $imageFileName = $utils->upload($agency->getAssetFile(), "uploads/agencies/");
                $agency->setLogo($imageFileName);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($agency);
            $em->flush();

            return $this->redirectToRoute('agency_edit', array('id' => $agency->getId()));
        }

        return $this->render('AdminBundle:agency:edit.html.twig', array(
            'agency' => $agency,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing agency entity.
     *
     * @Route("/agencies/{id}/add-user-manager", name="agency_add_manager")
     * @Method({"POST"})
     */
    public function addManagerAction(Request $request, Agency $agency)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository("AppBundle:User")->find($request->get('user_id'));
        $manager = new UserAgency();
        $manager->setUser($user);
        $manager->setAgency($agency);
        $em->persist($manager);
        $em->flush();
        return $this->redirectToRoute('agency_show', array('id' => $agency->getId()));

    }/**
     * Displays a form to edit an existing agency entity.
     *
     * @Route("/agencies/{id}/remove-user-manager", name="agency_remove_manager")
     * @Method({"GET"})
     */
    public function removeManagerAction(Request $request, Agency $agency)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository("AppBundle:User")->find($request->query->get('user_id'));
        $manager = $this->getDoctrine()->getRepository("AppBundle:UserAgency")->findOneBy(array("user"=>$user,"agency"=>$agency));
        $em->remove($manager);
        $em->flush();
        return $this->redirectToRoute('agency_show', array('id' => $agency->getId()));
    }

    /**
     * Deletes a agency entity.
     *
     * @Route("/agencies/{id}", name="agency_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Agency $agency)
    {
        $form = $this->createDeleteForm($agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($agency);
            $em->flush();
        }

        return $this->redirectToRoute('agency_index');
    }

    /**
     * Creates a form to delete a agency entity.
     *
     * @param Agency $agency The agency entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Agency $agency)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('agency_delete', array('id' => $agency->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
