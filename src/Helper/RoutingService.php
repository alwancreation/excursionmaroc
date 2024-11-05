<?php
namespace App\Helper;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RequestStack;

class RoutingService{
    /** @var  Router */
    protected $router;
    protected $request;
    protected $requestStack;


    public function __construct($router,RequestStack $requestStack)
    {
        $this->router = $router;
        $this->requestStack = $requestStack;
        $this->request = $this->requestStack->getCurrentRequest();
    }
    public function getUrl(Product $product){
        $utils = new Utils();
        return $this->router->generate('product_details',array(
            "id" => $product->getProductId(),
            "slug" => $utils->slugify(($product->getProductSlug())?$product->getProductSlug():$product.""),
            "category" => $utils->slugify($product->getCategory()),
            "_locale"=>$this->request->getLocale()
        ));
    }
    public function categoryUrl(Category $category){
        if($category->getCategoryId()<=3){
            return $this->router->generate('category_'.$category->getCategoryId().'_products_list');
        }
        return '#';
    }
    
}

