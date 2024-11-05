<?php

namespace App\Controller\Admin;

use App\Entity\AppSettings;
use App\Entity\Booking;
use App\Entity\Client;
use App\Entity\EntityHistory;
use App\Form\BookingType;
use App\Form\ClientType;
use App\Helper\Utils;
use App\Services\ApplicationSettings;
use PhpImap\Mailbox;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/settings")
 */
class SettingsController extends AbstractController
{
    /**
     * @Route("/", name="settings_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/settings/index.html.twig', [

        ]);
    }
    /**
     * @Route("/agency", name="agency_index", methods={"GET"})
     */
    public function agency(): Response
    {
        return $this->render('admin/settings/agency.html.twig', [

        ]);
    }

    /**
     * @Route("/update", name="settings_update", methods={"POST"})
     */
    public function update(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $params = $request->request->all();
        foreach (get_class_vars(ApplicationSettings::class) as $key => $var) {
            if(!isset($params[$key]) || in_array($key,['application_widget_whatsapp_active','application_widget_whatsapp_phone'])){
                continue;
            }
            $appSettings = $em->getRepository(AppSettings::class)->findOneBy(['key'=>$key]);
            if(!$appSettings){
                $appSettings = new AppSettings();
                $appSettings->setKey($key);
            }
            if($key==='application_logo'){
                if(isset($_FILES['application_logo']) && $_FILES['application_logo']['size']>10){
                    $utils = new Utils();
                    $file = new UploadedFile($_FILES['application_logo']['tmp_name'],$_FILES['application_logo']['name']);
                    $fileName = $utils->upload($file, "uploads/settings/");
                    if($fileName){
                        $appSettings->setValue($fileName);
                    }
                }
            }else{
                $appSettings->setValue($request->get($key));
            }
            $em->persist($appSettings);
            $em->flush();
        }


        $appSettings = $em->getRepository(AppSettings::class)->findOneBy(['key'=>'application_logo']);
        if(!$appSettings){
            $appSettings = new AppSettings();
            $appSettings->setKey('application_logo');
        }
        if(isset($_FILES['application_logo']) && $_FILES['application_logo']['size']>10){
            $utils = new Utils();
            $file = new UploadedFile($_FILES['application_logo']['tmp_name'],$_FILES['application_logo']['name']);
            $fileName = $utils->upload($file, "uploads/settings/");
            if($fileName){
                $appSettings->setValue($fileName);
            }
        }
        $em->persist($appSettings);
        $em->flush();


        return $this->redirect($this->generateUrl("settings_index"));

    }

    /**
     * @Route("/update/agency", name="agency_update", methods={"POST"})
     */
    public function updateAgency(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $params = $request->request->all();
        foreach (get_class_vars(ApplicationSettings::class) as $key => $var) {
            if(!isset($params[$key]) ){
                continue;
            }
            $appSettings = $em->getRepository(AppSettings::class)->findOneBy(['key'=>$key]);
            if(!$appSettings){
                $appSettings = new AppSettings();
                $appSettings->setKey($key);
            }
            $appSettings->setValue($request->get($key));

            $em->persist($appSettings);
            $em->flush();
        }

        return $this->redirect($this->generateUrl("agency_index"));

    }

    /**
     * @Route("/update-widgets", name="settings_update_widgets", methods={"POST"})
     */
    public function settings_update_widgets(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $params = $request->request->all();
        foreach (['application_widget_whatsapp_active','application_widget_whatsapp_phone'] as $key) {
            $appSettings = $em->getRepository(AppSettings::class)->findOneBy(['key'=>$key]);
            if(!$appSettings){
                $appSettings = new AppSettings();
                $appSettings->setKey($key);
            }
            $appSettings->setValue($request->get($key));
            $em->persist($appSettings);
            $em->flush();
        }
        $em->persist($appSettings);
        $em->flush();


        return $this->redirect($this->generateUrl("settings_index"));

    }
}
