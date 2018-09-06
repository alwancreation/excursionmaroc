<?php

namespace AppBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;

class DatabaseGlobalsExtension extends \Twig_Extension
{

    protected $em;
    protected $container;

    public function __construct(EntityManager $em, Container $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function getGlobals()
    {
        $settings = $this->em->getRepository('AppBundle:Settings')->findAll();
        $categories = $this->em->getRepository('AppBundle:Category')->findAll();
        $vehicles = $this->em->getRepository('AppBundle:Destination')->findAll();
        $themes = $this->em->getRepository('AppBundle:Theme')->findAll();
        $settingsObject = new \stdClass();
        foreach ($settings as $setting){
            $settingsObject->{$setting->getSettingKey()} = $setting->getSettingValue();
        }
        return array (
            "app_settings" => $settingsObject,
            "app_categories" => $categories,
            "app_destinations" => $vehicles,
            "app_themes" => $themes,
            "seo_service" => $this->container->get('seo_service'),
            "routing_service" => $this->container->get('routing_service')
        );
    }

    public function getName()
    {
        return "AppBundle:DatabaseGlobalsExtension";
    }

}