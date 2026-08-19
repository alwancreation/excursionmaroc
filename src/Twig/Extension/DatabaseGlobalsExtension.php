<?php

namespace App\Twig\Extension;

use App\Helper\Utils;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\TwigBundle\DependencyInjection\TwigExtension;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class DatabaseGlobalsExtension extends AbstractExtension implements GlobalsInterface
{
    protected $em;
    protected $container;

    public function __construct(EntityManagerInterface $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function getName()
    {
        return "DatabaseGlobalsExtension";
    }

    public function getGlobals(): array
    {

        $categories = $this->em->getRepository('App\Entity\Category')->findAll();
        $vehicles = $this->em->getRepository('App\Entity\Destination')->findAll();
        $themes = $this->em->getRepository('App\Entity\Theme')->findAll();
        return array (
            "app_categories" => $categories,
            "app_destinations" => $vehicles,
            "app_themes" => $themes,
            "online_carts_count" => 0,
//            "cmi_action_slk" => $this->container->getParameter('cmi_action_slk'),
//            "cmi_store_id" => $this->container->getParameter('cmi_store_id'),
//            "cmi_store_key" => $this->container->getParameter('cmi_store_key'),
//            "cmi_checksum" => Utils::$checksum,
        );
    }
}