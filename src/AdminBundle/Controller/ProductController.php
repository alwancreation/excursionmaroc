<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\Asset;
use AppBundle\Entity\CustomProperty;
use AppBundle\Entity\Product;
use AppBundle\Entity\ProductPrice;
use AppBundle\Helper\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 * @Route("products")
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     * @Route("/", name="product_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Product')->findAllGranted($this->getUser());

        return $this->render('AdminBundle:product:index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Creates a new product entity.
     *
     * @Route("/new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('AppBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $agency = $em->getRepository("AppBundle:Agency")->findOneByUser($this->getUser());
            if($agency){
                $product->setAgency($agency);
            }
            $em->persist($product);
            $em->flush($product);

            return $this->redirectToRoute('product_index');
        }

        return $this->render('AdminBundle:product:new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/{id}", name="product_show")
     * @Method("GET")
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('AdminBundle:product:show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/product/custom-properties", name="product_get_custom_properties",options = { "expose" = true })
     */
    public function customPropertiesAction(Request $request)
    {
        $em = $this->getDoctrine();
        $product = $em->getRepository("AppBundle:Product")->find($request->get('product_id'));
        $properties = $product->getCustomProperties();
        $result = $this->toArray($properties);
        return new JsonResponse($result);
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/product/add-custom-property", name="product_add_custom_property",options = { "expose" = true })
     */
    public function addCustomPropertyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("AppBundle:Product")->find($request->get('product_id'));
        $customProperty = new CustomProperty();
        $customProperty->setUser($this->getUser());
        $customProperty->setProduct($product);
        $customProperty->setCustomPropertyName($request->get('name'));
        $customProperty->setCustomPropertyDescription($request->get('description'));
        $customProperty->setCustomPropertyType($request->get('type'));

        $em->persist($customProperty);
        $em->flush();

        $properties = $product->getCustomProperties();
        $result = $this->toArray($properties);
        return new JsonResponse($result);
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/product/update-custom-property", name="product_update_custom_property",options = { "expose" = true })
     */
    public function updateCustomPropertyAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $customProperty = $em->getRepository("AppBundle:CustomProperty")->find($request->get('id'));
//        $editable_lang = $request->get('lang','fr');
//        $customProperty->setTranslatableLocale($editable_lang);
//        $em->refresh($customProperty);

        $customProperty->setCustomPropertyName($request->get('name'));
        $customProperty->setCustomPropertyDescription($request->get('description'));
        $customProperty->setCustomPropertyType($request->get('type'));

        $em->persist($customProperty);
        $em->flush();


        $result = $this->toArray($customProperty->getProduct()->getCustomProperties());
        return new JsonResponse($result);
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/product/delete-custom-property", name="product_delete_custom_property",options = { "expose" = true })
     */
    public function deleteCustomPropertyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $prop = $em->getRepository("AppBundle:CustomProperty")->find($request->get('id'));
        $em->remove($prop);
        $em->flush();
        return new JsonResponse(["success"=>true]);
    }


    public function toArray($collection){
        $result = [];
        /** @var CustomProperty $value */
        foreach ($collection as $value){
            $result[] = array(
                "id" => $value->getCustomPropertyId(),
                "name" => $value->getCustomPropertyName(),
                "description" => $value->getCustomPropertyDescription(),
                "type" => $value->getCustomPropertyType(),
                "product_id" => $value->getProduct()->getProductId(),
            );
        }
        return $result;
    }
    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Product $product)
    {
        if(!$product->getAccess($this->getUser())){
            throw new \Exception("Not found",404);
        }

        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('AppBundle\Form\ProductType', $product);
        $productPrice = $product->getPrices();
        if(!$productPrice){
            $productPrice = new ProductPrice();
            $productPrice->setUser($this->getUser());
            $productPrice->setProduct($product);
        }



        $editFormPrices = $this->createForm('AppBundle\Form\ProductPriceType', $productPrice);
        $editForm->handleRequest($request);
        $editFormPrices->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if($product->getAttachedFile()){
                $asset = new Asset();
                $utils = new Utils();
                $fileName = $utils->upload($product->getAttachedFile(), "uploads/attached/");
                $asset->setAssetTitle($product->getAttachedFile()->getClientOriginalName());
                $asset->setAssetBasePath($fileName);
                $product->setAttached($asset);
            }

            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('product_edit', array('id' => $product->getProductId()));
        }
        if ($editFormPrices->isSubmitted() && $editFormPrices->isValid()) {
            $em->persist($productPrice);
            $em->flush();
            return $this->redirectToRoute('product_edit', array('id' => $product->getProductId()));
        }


        return $this->render('AdminBundle:product:edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'edit_form_prices' => $editFormPrices->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a product entity.
     *
     * @Route("/delete/{id}", name="product_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Product $product)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush($product);
        return $this->redirectToRoute('product_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getProductId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/add-photo", name="product_add_photo")
     * @Method({"POST"})
     */
    public function addPhotoAction(Request $request, Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $photos = $request->files;
        foreach ($photos as $photo){
            $asset = new Asset();
            $Utils = new Utils();
            $fileName = $Utils->upload($photo,"uploads/originals/");
            $asset->setAssetBasePath($fileName);
            $product->addAsset($asset);
        }
        $em->persist($product);
        $em->flush();
        return new JsonResponse(array("success"=>1));
    }
    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{asset_id}/delete-photo/{product_id}", name="delete_product_photo")
     * @ParamConverter("asset", options={"mapping": {"asset_id" : "assetId"}})
     * @ParamConverter("product", options={"mapping": {"product_id" : "productId"}})
     * @Method({"GET"})
     */
    public function deletePhotoAction(Request $request,Asset $asset, Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $product->removeAsset($asset);
        $em->persist($product);
        $em->flush();
        return $this->redirectToRoute('product_edit',array("id"=>$product->getProductId()));
    }
}
