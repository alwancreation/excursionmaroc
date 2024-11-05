<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\Asset;
use AppBundle\Entity\Slider;
use AppBundle\Helper\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Slider controller.
 *
 * @Route("slider")
 */
class SliderController extends Controller
{
//    /**
//     * Lists all slider entities.
//     *
//     * @Route("/", name="slider_index")
//     * @Method("GET")
//     */
//    public function indexAction()
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $sliders = $em->getRepository('AppBundle:Slider')->findAll();
//
//        return $this->render('slider/index.html.twig', array(
//            'sliders' => $sliders,
//        ));
//    }
//
//    /**
//     * Creates a new slider entity.
//     *
//     * @Route("/new", name="slider_new")
//     * @Method({"GET", "POST"})
//     */
//    public function newAction(Request $request)
//    {
//        $slider = new Slider();
//        $form = $this->createForm('AppBundle\Form\SliderType', $slider);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($slider);
//            $em->flush($slider);
//
//            return $this->redirectToRoute('slider_show', array('id' => $slider->getId()));
//        }
//
//        return $this->render('slider/new.html.twig', array(
//            'slider' => $slider,
//            'form' => $form->createView(),
//        ));
//    }
//
//    /**
//     * Finds and displays a slider entity.
//     *
//     * @Route("/{id}", name="slider_show")
//     * @Method("GET")
//     */
//    public function showAction(Slider $slider)
//    {
//        $deleteForm = $this->createDeleteForm($slider);
//
//        return $this->render('slider/show.html.twig', array(
//            'slider' => $slider,
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }

    /**
     * Displays a form to edit an existing slider entity.
     *
     * @Route("/{id}/edit", name="slider_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Slider $slider)
    {
        $deleteForm = $this->createDeleteForm($slider);
        $editForm = $this->createForm('AppBundle\Form\SliderType', $slider);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('slider_edit', array('id' => $slider->getSliderId()));
        }

        return $this->render('AdminBundle:slider:edit.html.twig', array(
            'slider' => $slider,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a slider entity.
     *
     * @Route("/{id}", name="slider_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Slider $slider)
    {
        $form = $this->createDeleteForm($slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($slider);
            $em->flush($slider);
        }

        return $this->redirectToRoute('slider_index');
    }

    /**
     * Creates a form to delete a slider entity.
     *
     * @param Slider $slider The slider entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Slider $slider)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('slider_delete', array('id' => $slider->getSliderId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



    /**
     * Displays a form to edit an existing slider entity.
     *
     * @Route("/{id}/add-photo", name="slider_add_photo")
     * @Method({"POST"})
     */
    public function addPhotoAction(Request $request, Slider $slider)
    {
        $em = $this->getDoctrine()->getManager();
        $photos = $request->files;
        foreach ($photos as $photo){
            $asset = new Asset();
            $Utils = new Utils();
            $fileName = $Utils->upload($photo,"uploads/originals/");
            $asset->setAssetBasePath($fileName);
            $slider->addAsset($asset);
        }
        $em->persist($slider);
        $em->flush();
        return new JsonResponse(array("success"=>1));
    }



    /**
     * Displays a form to edit an existing slider entity.
     *
     * @Route("/{asset_id}/delete-photo/{slider_id}", name="delete_slider_photo")
     * @ParamConverter("asset", options={"mapping": {"asset_id" : "assetId"}})
     * @ParamConverter("slider", options={"mapping": {"slider_id" : "sliderId"}})
     * @Method({"GET"})
     */
    public function deletePhotoAction(Request $request,Asset $asset, Slider $slider)
    {
        $em = $this->getDoctrine()->getManager();
        $slider->removeAsset($asset);
        $em->persist($slider);
        $em->flush();
        return $this->redirectToRoute('slider_edit',array("id"=>$slider->getSliderId()));
    }

    /**
     * Displays a form to edit an existing slider entity.
     *
     * @Route("/{asset_id}/edit-photo/{slider_id}", name="edit_slider_photo")
     * @ParamConverter("asset", options={"mapping": {"asset_id" : "assetId"}})
     * @ParamConverter("slider", options={"mapping": {"slider_id" : "sliderId"}})
     */
    public function editPhotoAction(Request $request,Asset $asset, Slider $slider)
    {
        $editForm = $this->createForm('AppBundle\Form\AssetType', $asset);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('slider_edit', array('id' => $slider->getSliderId()));
        }

        return $this->render('AdminBundle:slider:edit-asset.html.twig', array(
            'slider' => $slider,
            'edit_form' => $editForm->createView(),
        ));
    }
}
