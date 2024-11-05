<?php

namespace AppBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * A TWIG Extension which allows to show Controller and Action name in a TWIG view.
 * 
 * The Controller/Action name will be shown in lowercase. For example: 'default' or 'index'
 * 
 */
class ControllerActionExtension extends \Twig_Extension
{

    
    /**
     * @var Request 
     */
    protected $request;

    protected $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->request = $this->requestStack->getCurrentRequest();

    }

    



   /**
    * @var \Twig_Environment
    */
    protected $environment;

   
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_Function('get_controller_name', [$this, 'getControllerName']),
            new \Twig_Function('get_action_name', [$this, 'getActionName']),
            new \Twig_Function('active_class', [$this, 'getActiveClass']),
        );
    }

    public function app_devise_code($price=null){
        $session = $this->request->getSession();
        $currency = $session->get('app_currency');
        if($currency && $currency!='euro'){
            return 'MAD';
        }
        return 'EUR';

    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('app_devise_code', array($this, 'app_devise_code')),
            new \Twig_SimpleFilter('my_price', array($this, 'priceFormat')),
            new \Twig_SimpleFilter('my_yes_no', array($this, 'yesOrNo')),
            new \Twig_SimpleFilter('my_progress', array($this, 'myProgress'), array(
                'is_safe' => array('html')
            )),
            new \Twig_SimpleFilter('countDays', array($this, 'countDays'), array(
                'is_safe' => array('html')
            )),
            new \Twig_SimpleFilter('my_yes_no_label', array($this, 'yesOrNoLabel'), array(
                'is_safe' => array('html')
            )),
        );
    }


    public function priceFormat($price=null){
        if($price!==null){
            return $price." €";
        }

    }
    public function yesOrNo($val=null){
        if($val!==null){
            if ($val==0) {
                return "Non";
            }
            if ($val==1) {
                return "Oui";
            }

        }
    }


    /**
     * @param null $val
     * @return string
     */
    public function yesOrNoLabel($val=null){
        if($val!==null){
            if ($val==0) {
                return '<b class="label label-danger">Non</b>';
            }
            if ($val==1) {
                return '<b class="label label-success">Oui</b>';
            }

        }

    }

    /**
     * @param \DateTime|null $dateFrom
     * @param \DateTime|null $dateTo
     * @return string
     */
    public function myProgress(\DateTime $dateFrom=null,\DateTime $dateTo=null){
        $percent=0;
        $html='<div style="min-width:200px;">';

            $html.='<div class="row">';

            $html.='<div class="col-xs-6" style="font-size: 11px;">';
            if($dateFrom!=null){
                $html.=$dateFrom->format('d-m-Y');
            }else{
                $html.="...";
            }
            $html.='</div>';

            $html.='<div class="col-xs-6 text-right" style="font-size: 11px;">';
            if($dateFrom!=null){
                $html.=$dateTo->format('d-m-Y');
            }else{
                $html.="...";
            }
            $html.='</div>';

            $html.='</div>';
        $class='success';
        if($dateFrom!=null && $dateTo!=null){
            $dateNow=new \DateTime();
            if($dateNow<=$dateTo && $dateNow>=$dateFrom){
                $dateNowTime=$dateNow->getTimestamp();
                $dateToTime=$dateTo->getTimestamp();
                $dateFromTime=$dateFrom->getTimestamp();

                $total = $dateToTime - $dateFromTime;
                $elapsed = $dateNowTime - $dateFromTime;

                $percent = floor($elapsed*100/$total);
                if($percent>50){
                    $class='warning';
                }
            }elseif($dateNow>$dateTo){
                $class='danger';
                $percent = 100;
            }
        }

        $html.='<div class="progress" style="height: 10px; margin-bottom: 0;">';
          $html.='<div class="progress-bar progress-bar-'.$class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$percent.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percent.'%">';
          $html.='</div>';
        $html.='</div>';
        $html.='</div>';
        return $html;
    }

    /**
     * @param \DateTime|null $dateFrom
     * @param \DateTime|null $dateTo
     * @return string
     */
    public function countDays(\DateTime $dateFrom=null,\DateTime $dateTo=null){
        $jours = -1;
        if($dateFrom!=null && $dateTo!=null){
            $dateNow=new \DateTime();
            if($dateNow<=$dateTo && $dateNow>=$dateFrom){
                $dateNowTime=$dateNow->getTimestamp();
                $dateToTime=$dateTo->getTimestamp();
                $dateFromTime=$dateFrom->getTimestamp();

                $elapsed = abs($dateNowTime - $dateToTime);

                $jours = floor($elapsed/60/60/24);

            }elseif($dateNow>$dateTo){
                $jours = 0;
            }
        }

        if ($jours==0){
            return "<span class='hide'>0</span>Expiré";
        }
        if ($jours>0){
            return "<span class='hide'>$jours</span>".$jours." jour(s)";
        }
        return "<span class='hide'>Z</span>A venir";
}

    /**
    * Get current controller name
    */
    public function getControllerName()
    {

        if(null !== $this->request)
        {
            $pattern = "#Controller\\\([a-zA-Z]*)Controller#";
            $matches = array();
            preg_match($pattern, $this->request->get('_controller'), $matches);
            
            return strtolower($matches[1]);
        }

    }

    /**
    * Get current controller name
    */
    public function getActiveClass($tag)
    {

        if(null !== $this->request)
        {
            $pattern = "#Controller\\\([a-zA-Z]*)Controller#";
            $matches = array();
            preg_match($pattern, $this->request->get('_controller'), $matches);
            
            if(strtolower($matches[1])==$tag){
                return 'class=active';
            }
        }

    }

    /**
    * Get current action name
    */
    public function getActionName()
    {
        if(null !== $this->request)
        {
            $pattern = "#::([a-zA-Z]*)Action#";
            $matches = array();
            preg_match($pattern, $this->request->get('_controller'), $matches);

            return $matches[1];
        }
    }

    public function getName()
    {
        return 'my_controller_action_twig_extension';
    }
}