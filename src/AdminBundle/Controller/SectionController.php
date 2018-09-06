<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\Asset;
use AppBundle\Entity\Page;
use AppBundle\Entity\Section;
use AppBundle\Helper\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Section controller.
 *
 * @Route("section")
 */
class SectionController extends Controller
{
    /**
     * Lists all section entities.
     *
     * @Route("/", name="section_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sections = $em->getRepository('AppBundle:Section')->findAll();

        return $this->render('AdminBundle:section:index.html.twig', array(
            'sections' => $sections,
        ));
    }

    /**
     * Creates a new section entity.
     *
     * @Route("/new/page/{id}", name="section_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Page $page)
    {
        $section = new Section();
        $form = $this->createForm('AppBundle\Form\SectionType', $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if ($section->getAssetFile()){
                $asset = new Asset();
                $utils = new Utils();
                $imageFileName = $utils->upload($section->getAssetFile(), "uploads/images/home/");
                $asset->setAssetBasePath($imageFileName);
                $section->setMainAsset($asset);
            }
            if($section->getRemoveAsset()){
                $section->setMainAsset(null);
            }
            $section->setPage($page);

            $em->persist($section);
            $em->flush($section);

            return $this->redirectToRoute('pages_edit',["id"=>$page->getPageId()]);
        }

        return $this->render('AdminBundle:section:new.html.twig', array(
            'section' => $section,
            'page' => $page,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing section entity.
     *
     * @Route("/{id}/edit", name="section_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Section $section)
    {
        $deleteForm = $this->createDeleteForm($section);
        $editForm = $this->createForm('AppBundle\Form\SectionType', $section);
        


        $assetNew = new Asset();
        $formType = 'AppBundle\Form\AssetSectionType';
        if($section->getSectionType()==3){
            // $formType = 'AppBundle\Form\AssetSectionProductsType';
        }
        $assetForm = $this->createForm($formType, $assetNew, array(
            'action' => $this->generateUrl('section_add_asset',array("id"=>$section->getSectionId())),
            'method' => 'POST',
        ));

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ($section->getAssetFile()){
                $asset = new Asset();
                $utils = new Utils();
                $imageFileName = $utils->upload($section->getAssetFile(), "uploads/images/home/");
                $asset->setAssetBasePath($imageFileName);
                $section->setMainAsset($asset);
            }
            if($section->getRemoveAsset()){
                $section->setMainAsset(null);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('section_edit', array('id' => $section->getSectionId()));
        }

        return $this->render('AdminBundle:section:edit.html.twig', array(
            'section' => $section,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'assetForm' => $assetForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing section entity.
     *
     * @Route("/{id}/add-asset", name="section_add_asset")
     * @Method({"POST"})
     */
    public function addAssetAction(Request $request, Section $section)
    {
        $assetNew = new Asset();
        $formType = 'AppBundle\Form\AssetSectionType';
        if($section->getSectionType()==3){
            // $formType = 'AppBundle\Form\AssetSectionProductsType';
        }
        $assetForm = $this->createForm($formType, $assetNew, array(
            'action' => $this->generateUrl('section_add_asset',array("id"=>$section->getSectionId())),
            'method' => 'POST',
        ));
        $assetForm->handleRequest($request);

        if ($assetForm->isSubmitted() && $assetForm->isValid()) {
            $utils = new Utils();

            if($assetNew->getAssetFile()){
                $imageFileName = $utils->upload($assetNew->getAssetFile(), "uploads/images/home/");
                $assetNew->setAssetBasePath($imageFileName);
            }
            $section->addAsset($assetNew);
            $em = $this->getDoctrine()->getManager();
            $em->persist($section);
            $em->flush();

            return $this->redirectToRoute('section_edit', array('id' => $section->getSectionId()));
        }



    }

    /**
     * Displays a form to edit an existing section entity.
     *
     * @Route("/edit/{id}/edit-asset", name="section_edit_asset")
     */
    public function editAssetAction(Request $request, Asset $asset)
    {
        $em = $this->getDoctrine()->getManager();

        $formType = 'AppBundle\Form\AssetSectionType';
        $section = $em->getRepository("AppBundle:Section")->find($request->query->get("section_id"));
        $assetForm = $this->createForm($formType, $asset, array(
            'action' => $this->generateUrl('section_edit_asset',array("id"=>$asset->getAssetId(),"section_id"=>$section->getSectionId())),
            'method' => 'POST',
        ));
        $assetForm->handleRequest($request);

        if ($assetForm->isSubmitted() && $assetForm->isValid()) {
            $utils = new Utils();
            if($asset->getAssetFile()){
                $imageFileName = $utils->upload($asset->getAssetFile(), "uploads/images/home/");
                $asset->setAssetBasePath($imageFileName);
            }
            $em->persist($asset);
            $em->flush();
            return $this->redirectToRoute('section_edit', array('id' => $section->getSectionId()));
        }

        return $this->render('AdminBundle:section:edit-asset.html.twig', array(
            'section' => $section,
            'asset' => $asset,
            'assetForm' => $assetForm->createView(),
        ));


    }

    /**
     * Displays a form to edit an existing section entity.
     *
     * @Route("/asset/{id}/remove-asset", name="section_delete_asset")
     * @Method({"GET"})
     */
    public function removeAssetAction(Request $request, Asset $asset)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($asset);
            $em->flush();
            return $this->redirectToRoute('section_edit', array('id' => $request->query->get('section_id')));

    }

    /**
     * Deletes a section entity.
     *
     * @Route("/delete/{id}", name="section_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Section $section)
    {
        $em = $this->getDoctrine()->getManager();
        $page_id = $section->getPage()->getPageId();
        $em->remove($section);
        $em->flush($section);
//        return $this->redirectToRoute('section_index');
        return $this->redirectToRoute('pages_edit',['id'=>$page_id]);
    }

    /**
     * Creates a form to delete a section entity.
     *
     * @param Section $section The section entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Section $section)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('section_delete', array('id' => $section->getSectionId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
