<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RemoteController
 * @Route("remote")
 */
class RemoteController extends Controller
{
    /**
     * @Route("/price", name="product_price")
     */
    public function indexAction(Request $request)
    {
        $id = $request->get('id');
        $adult = $request->get('adults');
        $children = $request->get('children');
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Product')->find($id);
        if(!$product){
            return new JsonResponse(array());
        }
        return new JsonResponse(
            array(
                "price"=>$product->getPrice($adult,$children)
            )
        );
    }


}
