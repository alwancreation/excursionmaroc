<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\Asset;
use AppBundle\Entity\Destination;
use AppBundle\Helper\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Destination controller.
 *
 * @Route("destination")
 */
class DestinationController extends Controller
{
    /**
     * Lists all destination entities.
     *
     * @Route("/", name="destination_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $destinations = $em->getRepository('AppBundle:Destination')->findAll();

        return $this->render('AdminBundle:destination:index.html.twig', array(
            'destinations' => $destinations,
        ));
    }

    /**
     * Creates a new destination entity.
     *
     * @Route("/new", name="destination_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $destination = new Destination();
        $form = $this->createForm('AppBundle\Form\DestinationType', $destination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if ($destination->getAssetFile()){
                $asset = new Asset();
                $utils = new Utils();
                $imageFileName = $utils->upload($destination->getAssetFile(), "uploads/originals/");
                $asset->setAssetBasePath($imageFileName);
                $destination->setMainAsset($asset);
            }

            $em->persist($destination);
            $em->flush($destination);

            return $this->redirectToRoute('destination_index');
        }

        return $this->render('AdminBundle:destination:new.html.twig', array(
            'destination' => $destination,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a destination entity.
     *
     * @Route("/{id}", name="destination_show")
     * @Method("GET")
     */
    public function showAction(Destination $destination)
    {
        $deleteForm = $this->createDeleteForm($destination);

        return $this->render('AdminBundle:destination:show.html.twig', array(
            'destination' => $destination,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing destination entity.
     *
     * @Route("/{id}/edit", name="destination_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Destination $destination)
    {
        $deleteForm = $this->createDeleteForm($destination);
        $editForm = $this->createForm('AppBundle\Form\DestinationType', $destination);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if ($destination->getAssetFile()){
                $asset = new Asset();
                $utils = new Utils();
                $imageFileName = $utils->upload($destination->getAssetFile(), "uploads/originals/");
                $asset->setAssetBasePath($imageFileName);
                $destination->setMainAsset($asset);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('destination_edit', array('id' => $destination->getDestinationId()));
        }

        return $this->render('AdminBundle:destination:edit.html.twig', array(
            'destination' => $destination,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a destination entity.
     *
     * @Route("/{id}", name="destination_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Destination $destination)
    {
        $form = $this->createDeleteForm($destination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($destination);
            $em->flush($destination);
        }

        return $this->redirectToRoute('destination_index');
    }

    /**
     * Creates a form to delete a destination entity.
     *
     * @param Destination $destination The destination entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Destination $destination)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('destination_delete', array('id' => $destination->getDestinationId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
