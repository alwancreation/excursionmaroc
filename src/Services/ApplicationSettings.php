<?php
namespace App\Services;

use App\Entity\AppSettings;
use App\Entity\User;
use App\Entity\Vehicle;
use App\Helper\Utils;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\Container;

class ApplicationSettings{
    /** @var  Router */
    protected $router;
    protected $em;
    protected $container;

    public $application_name='Application Name';
    public $application_about='About Application';
    public $application_email='info@example.com';
    public $application_site='www.example.com';
    public $application_phone=null;
    public $application_address=null;
    public $application_gsm=null;
    public $application_logo=null;

    public $application_transfer_type_arrival='Arrival';
    public $application_transfer_type_departure='Departure';
    public $application_transfer_type_transfer='Transfer';

    public $application_currency='USD';

    public $header_script;
    public $footer_script;

    public $application_widget_whatsapp_active;
    public $application_widget_whatsapp_phone;

    public $application_cut_off_hours=6;

    public $application_currency_dhs='10';

    //•	Infos Juridiques
    public $application_agency_name='Application Name';
    public $application_agency_ice='ICE 0000000';
    public $application_agency_rc='RC 0000000';
    public $application_agency_patente='Patente 0000000';

    public $application_agency_phone;
    public $application_agency_gsm;
    public $application_agency_email;
    public $application_agency_address;
    public $application_agency_if;

    public function __construct(Router $router,EntityManager $em, Container $container)
    {
        $this->router = $router;
        $this->em = $em;
        $this->container = $container;

        $appSettings = $this->em->getRepository(AppSettings::class)->findAll();
        foreach ($appSettings as $appSettingLine){
            $this->{$appSettingLine->getKey()} = $appSettingLine->getValue();
        }
    }

    public function priceFormat($price = null){
        return Utils::priceFormat($price,$this,false);
    }
    public function convertedPrice($price = null){
        return Utils::convertedPrice($price,$this);
    }



}

