<?php
namespace AppBundle\Helper;

use AppBundle\Entity\Agency;
use AppBundle\Entity\Category;
use AppBundle\Entity\Destination;
use AppBundle\Entity\Product;
use AppBundle\Entity\Theme;
use AppBundle\Entity\Vehicle;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class RoutingService{
    /** @var  Router */
    protected $router;
    public function __construct($router)
    {
        $this->router = $router;
    }
    public function getUrl(Product $product){
        $utils = new Utils();
        return $this->router->generate('product_details',array(
            "id" => $product->getProductId(),
            "slug" => $utils->slugify(($product->getProductSlug())?$product->getProductSlug():$product.""),
            "category" => $utils->slugify($product->getCategory()),
        ));
    }
    public function getDestinationUrl(Destination $destination){
        return $this->router->generate('all_products_list',array(
            "destination" => $destination->getDestinationId(),
        ));
    }
    public function getThemeUrl(Theme $theme){
        return $this->router->generate('all_products_list',array(
            "theme" => $theme->getThemeId(),
        ));
    }
    public function getAgencyUrl(Agency $agency){
        return $this->router->generate('front_agency_details',array(
            "slug" => $agency->getSlug()
        ));
    }
    public function getCategoryUrl(Category $category){
        if($category->getCategoryId()==2){
            return $this->router->generate('excursions_products_list');
        }
        if($category->getCategoryId()==1){
            return $this->router->generate('circuits_products_list');
        }
        if($category->getCategoryId()==3){
            return $this->router->generate('transfers_index');
        }
        return '#';

    }

}

