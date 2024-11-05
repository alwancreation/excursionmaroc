<?php
namespace AppBundle\Helper;

use AppBundle\Entity\Page;
use AppBundle\Entity\Product;
use AppBundle\Entity\Settings;
use AppBundle\Entity\Vehicle;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\Container;

class SeoService{
    /** @var  Router */
    protected $router;
    protected $em;
    protected $container;

    public function __construct(Router $router,EntityManager $em, Container $container)
    {
        $this->router = $router;
        $this->em = $em;
        $this->container = $container;
    }
    public function getMeta(){
        $settings = $this->em->getRepository('AppBundle:Settings')->findAll();
        $settingsObject = new \stdClass();
        /** @var Settings $setting */
        foreach ($settings as $setting){
            $settingsObject->{$setting->getSettingKey()} = $setting->getSettingValue();
        }

        return '
        <title>'.$settingsObject->application_name.'</title>
        <meta name="description" content="'.$settingsObject->application_description.'">
        <meta property="og:title" content="'.$settingsObject->application_name.'"/>
        <meta property="og:type" content="website"/>
        <meta property="og:description" content="'.$settingsObject->application_description.'"/>
        ';

    }

    public function metaProduct(Product $product){
        $settings = $this->em->getRepository('AppBundle:Settings')->findAll();
        $settingsObject = new \stdClass();
        /** @var Settings $setting */
        foreach ($settings as $setting){
            $settingsObject->{$setting->getSettingKey()} = $setting->getSettingValue();
        }

        return '
        <title>'.$product->getProductName().' - '.$settingsObject->application_name.'</title>
        <meta name="description" content="'.substr($product->getProductShortDescription(),0,200).'">
        <meta property="og:title" content="'.$product->getProductName().' - '.$settingsObject->application_name.'"/>
        <meta property="og:type" content="website"/>
        <meta property="og:description" content="'.substr($product->getProductShortDescription(),0,200).'"/>
        ';

    }

    public function metaPage(Page $page){
        $meta = $page->getMeta();
        if($meta  && $meta->getMetaTitle()){
            return '
            <title>'.$meta->getMetaTitle().'</title>
            <meta name="description" content="'.$meta->getMetaDescription().'">
            <meta name="keywords" content="'.$meta->getMetaKeywords().'">
            <meta property="og:title" content="'.$meta->getMetaTitle().'"/>
            <meta property="og:type" content="website"/>
            <meta property="og:description" content="'.$meta->getMetaDescription().'"/> 
            '.$meta->getMetaPlus();
        }
        $settings = $this->em->getRepository('AppBundle:Settings')->findAll();
        $settingsObject = new \stdClass();
        /** @var Settings $setting */
        foreach ($settings as $setting){
            $settingsObject->{$setting->getSettingKey()} = $setting->getSettingValue();
        }

        return '
        <title>'.$page->getPageTitle().' - '.$settingsObject->application_name.'</title>
        <meta name="description" content="'.substr($page->getPageShortDescription(),0,200).'">
        <meta property="og:title" content="'.$page->getPageTitle().' - '.$settingsObject->application_name.'"/>
        <meta property="og:type" content="website"/>
        <meta property="og:description" content="'.substr($page->getPageShortDescription(),0,200).'"/>
        ';

    }
    
}

