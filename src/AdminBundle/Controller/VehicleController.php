<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\Vehicle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vehicle controller.
 *
 * @Route("vehicles")
 */
class VehicleController extends Controller
{
    /**
     * Lists all vehicle entities.
     *
     * @Route("/", name="vehicules_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vehicles = $em->getRepository('AppBundle:Vehicle')->findAll();

        return $this->render('AdminBundle:vehicle:index.html.twig', array(
            'vehicles' => $vehicles,
        ));
    }

    /**
     * Creates a new vehicle entity.
     *
     * @Route("/new", name="vehicules_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vehicle = new Vehicle();
        $form = $this->createForm('AppBundle\Form\VehicleType', $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehicle);
            $em->flush($vehicle);

            return $this->redirectToRoute('vehicules_show', array('id' => $vehicle->getVehicleId()));
        }

        return $this->render('AdminBundle:vehicle:new.html.twig', array(
            'vehicle' => $vehicle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vehicle entity.
     *
     * @Route("/{id}", name="vehicules_show")
     * @Method("GET")
     */
    public function showAction(Vehicle $vehicle)
    {
        $deleteForm = $this->createDeleteForm($vehicle);

        return $this->render('AdminBundle:vehicle:show.html.twig', array(
            'vehicle' => $vehicle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vehicle entity.
     *
     * @Route("/{id}/edit", name="vehicules_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Vehicle $vehicle)
    {
        $deleteForm = $this->createDeleteForm($vehicle);
        $editForm = $this->createForm('AppBundle\Form\VehicleType', $vehicle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehicules_edit', array('id' => $vehicle->getVehicleId()));
        }

        return $this->render('AdminBundle:vehicle:edit.html.twig', array(
            'vehicle' => $vehicle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vehicle entity.
     *
     * @Route("/{id}", name="vehicules_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Vehicle $vehicle)
    {
        $form = $this->createDeleteForm($vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vehicle);
            $em->flush($vehicle);
        }

        return $this->redirectToRoute('vehicules_index');
    }

    /**
     * Creates a form to delete a vehicle entity.
     *
     * @param Vehicle $vehicle The vehicle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Vehicle $vehicle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehicules_delete', array('id' => $vehicle->getVehicleId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
