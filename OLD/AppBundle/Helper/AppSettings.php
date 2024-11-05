<?php
namespace AppBundle\Helper;

use AppBundle\Entity\Page;
use AppBundle\Entity\Product;
use AppBundle\Entity\Settings;
use AppBundle\Entity\Vehicle;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\Container;

class AppSettings{
    /** @var  Router */
    protected $router;
    protected $em;
    protected $container;

    public function __construct(Router $router,EntityManager $em, Container $container)
    {
        $this->router = $router;
        $this->em = $em;
        $this->container = $container;

        $settings = $this->em->getRepository('AppBundle:Settings')->findAll();
        /** @var Settings $setting */
        foreach ($settings as $setting){
            $this->{$setting->getSettingKey()} = $setting->getSettingValue();
        }
    }
    
    
}

