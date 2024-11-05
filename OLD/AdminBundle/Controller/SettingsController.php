<?php

namespace AdminBundle\Controller;
use AppBundle\Entity\ModelSettings;
use AppBundle\Entity\Settings;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Services controller.
 *
 * @Route("/settings")
 */
class SettingsController extends Controller
{
    /**
     * Lists all Services entities.
     *
     * @Route("/", name="settings_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $settings = $em->getRepository('AppBundle:Settings')->findAll();
        $ModelSettings = new ModelSettings();
        $ModelSettings->parse($settings);
        return $this->render('AdminBundle:settings:index.html.twig', array(
            'settings' => $ModelSettings,
        ));
    }

    /**
     * Update
     *
     * @Route("/update", name="settings_update")
     * @Method({"POST"})
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $params = $request->request->all();
        if(is_array($params) && count($request)>0){
            $repo = $em->getRepository('AppBundle:Settings');
            foreach($params as $key => $value){
                $line = $repo->findOneBy(array("settingKey"=>$key));
                if($line){
                    $line->setSettingValue($value);
                }else{
                    $line = new Settings();
                    $line->setSettingKey($key);
                    $line->setSettingValue($value);
                }
                $em->persist($line);
            }
            $em->flush();
        }
        return $this->redirectToRoute('settings_index');
    }


}
