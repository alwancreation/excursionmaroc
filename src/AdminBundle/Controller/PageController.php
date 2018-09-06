<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\Asset;
use AppBundle\Entity\Meta;
use AppBundle\Entity\Page;
use AppBundle\Helper\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Page controller.
 *
 * @Route("pages")
 */
class PageController extends Controller
{
    /**
     * Lists all page entities.
     *
     * @Route("/", name="pages_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pages = $em->getRepository('AppBundle:Page')->findAll();

        return $this->render('AdminBundle:page:index.html.twig', array(
            'pages' => $pages,
        ));
    }

    /**
     * Creates a new page entity.
     *
     * @Route("/new", name="pages_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm('AppBundle\Form\PageType', $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($page->getAssetFile()){
                $asset = new Asset();
                $utils = new Utils();
                $imageFileName = $utils->upload($page->getAssetFile(), "uploads/originals/");
                $asset->setAssetBasePath($imageFileName);
                $page->setAsset($asset);
            }
            $em->persist($page);
            $em->flush($page);

            return $this->redirectToRoute('pages_index');
        }

        return $this->render('AdminBundle:page:new.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a page entity.
     *
     * @Route("/{id}", name="pages_show")
     * @Method("GET")
     */
    public function showAction(Page $page)
    {
        $deleteForm = $this->createDeleteForm($page);

        return $this->render('AdminBundle:page:show.html.twig', array(
            'page' => $page,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing page entity.
     *
     * @Route("/{id}/edit", name="pages_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Page $page)
    {

        $pageMeta = ($page->getMeta())?$page->getMeta():new Meta();
        $metaForm = $this->createForm('AppBundle\Form\MetaType', $pageMeta);
        $metaForm->handleRequest($request);
        if ($metaForm->isSubmitted() && $metaForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $page->setMeta($pageMeta);
            $em->persist($page);
            $em->flush();
            return $this->redirectToRoute('pages_edit', array('id' => $page->getPageId()));
        }


        $editForm = $this->createForm('AppBundle\Form\PageType', $page);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ($page->getAssetFile()){
                $asset = new Asset();
                $utils = new Utils();
                $imageFileName = $utils->upload($page->getAssetFile(), "uploads/originals/");
                $asset->setAssetBasePath($imageFileName);
                $page->setAsset($asset);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pages_edit', array('id' => $page->getPageId()));
        }

        return $this->render('AdminBundle:page:edit.html.twig', array(
            'page' => $page,
            'edit_form' => $editForm->createView(),
            'meta_form' => $metaForm->createView(),
        ));
    }

    /**
     * Deletes a page entity.
     *
     * @Route("/{id}", name="pages_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Page $page)
    {
        $form = $this->createDeleteForm($page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($page);
            $em->flush($page);
        }

        return $this->redirectToRoute('pages_index');
    }

    /**
     * Creates a form to delete a page entity.
     *
     * @param Page $page The page entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Page $page)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pages_delete', array('id' => $page->getPageId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
