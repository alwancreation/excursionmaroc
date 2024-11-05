<?php

namespace App\Twig;

use App\Entity\Currency;
use App\Helper\Utils;
use App\Services\ApplicationSettings;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    protected $request;
    protected $requestStack;
    /** @var ApplicationSettings  */
    var $appSettings;

    public function __construct(RequestStack $requestStack, ApplicationSettings $appSettings)
    {
        $this->requestStack = $requestStack;
        $this->request = $this->requestStack->getCurrentRequest();
        $this->appSettings = $appSettings;

    }

    public function getFilters()
    {
        return [
            new TwigFilter('daysLeft', [$this, 'daysLeft']),
            new TwigFilter('my_progress_days', [$this, 'my_progress_days']),
            new TwigFilter('priceFormat', array($this, 'priceFormat'), array(
                'is_safe' => array('html')
            )),
            new TwigFilter('customPriceFormat', array($this, 'customPriceFormat'), array(
                'is_safe' => array('html')
            )),
            new TwigFilter('wathsapplink', array($this, 'getWhatsappPhoneNumber'), array(
                'is_safe' => array('html')
            )),
            new TwigFilter('app_devise_code', array($this, 'app_devise_code')),
            new TwigFilter('my_price', array($this, 'priceFormat')),
            new TwigFilter('my_yes_no', array($this, 'yesOrNo')),
            new TwigFilter('my_progress', array($this, 'myProgress'), array(
                'is_safe' => array('html')
            )),
            new TwigFilter('countDays', array($this, 'countDays'), array(
                'is_safe' => array('html')
            )),
            new TwigFilter('my_yes_no_label', array($this, 'yesOrNoLabel'), array(
                'is_safe' => array('html')
            )),
        ];
    }

    public function app_devise_code($price=null){
        $session = $this->request->getSession();
        $currency = $session->get('app_currency');
        if($currency && $currency!='euro'){
            return 'MAD';
        }
        return 'EUR';

    }

    public function priceFormat($price = null)
    {
        if ($price !== null) {
            return Utils::priceFormat($price, $this->appSettings);

        }
    }
    public function customPriceFormat($price = null, Currency $currency = null)
    {
        if ($price !== null) {
            return Utils::customPriceFormat($price,$this->request, $this->appSettings,$currency);
        }
    }


    public function getWhatsappPhoneNumber($number)
    {
        $phoneNumber = $number;
        if($phoneNumber!='' && $phoneNumber!=null){
            $posplus = strpos(trim($phoneNumber),'+');
            if($posplus!==false){
                $phoneNumber =  str_replace('+','',$phoneNumber);
                $phoneNumber =  str_replace('(','',$phoneNumber);
                $phoneNumber =  str_replace(')','',$phoneNumber);
                $phoneNumber =  str_replace(' ','',$phoneNumber);

            }
        }
        $pos0 = strpos(trim($phoneNumber),'00');
        if($pos0!==false || $pos0===0){
            $phoneNumber = substr($phoneNumber,2);
        }
        return $phoneNumber;
    }

    /**
     * @param \DateTime|null $dateFrom
     * @param \DateTime|null $dateTo
     * @return string
     */
    public function daysLeft(\DateTime $dateFrom = null, \DateTime $dateTo = null)
    {

        if ($dateFrom != null && $dateTo != null) {
            $dateNow = new \DateTime();
            if ($dateNow <= $dateTo) {
                $dateNowTime = $dateNow->getTimestamp();
                $dateToTime = $dateTo->getTimestamp();
                $dateFromTime = $dateFrom->getTimestamp();

                $total = $dateToTime - $dateFromTime;
                $elapsed = $dateNowTime - $dateFromTime;
                return round(($total - $elapsed) / (3600 * 24));
            } elseif ($dateNow > $dateTo) {
                return 0;
            }
        }
        return null;
    }

    /**
     * @param \DateTime|null $dateFrom
     * @param \DateTime|null $dateTo
     * @return string
     */
    public function my_progress_days(\DateTime $dateFrom = null, \DateTime $dateTo = null)
    {

        if (!$dateFrom || !$dateTo) {
            return '';
        }


        $class = 'success';
        $left = 0;
        if ($dateFrom != null && $dateTo != null) {
            $dateNow = new \DateTime();
            if ($dateNow <= $dateTo && $dateNow >= $dateFrom) {
                $dateNowTime = $dateNow->getTimestamp();
                $dateToTime = $dateTo->getTimestamp();
                $dateFromTime = $dateFrom->getTimestamp();

                $total = $dateToTime - $dateFromTime;
                $elapsed = $dateNowTime - $dateFromTime;
                $left = ($total > $elapsed) ? (round(($total - $elapsed) / (3600 * 24))) : 0;

                if ($left <= 15) {
                    $class = 'warning';
                } elseif ($left <= 7) {
                    $class = 'danger';
                }
            } else {
                if ($dateNow >= $dateTo) {
                    $left = 0;
                    $class = 'danger';
                }
                if ($dateNow < $dateFrom && $dateNow < $dateTo) {
                    $dateNowTime = $dateNow->getTimestamp();
                    $dateToTime = $dateTo->getTimestamp();
                    $left = round(($dateToTime - $dateNowTime) / (3600 * 24));
                }
            }
        }
        $html = '<div style="width:212px;" class="delay-last-month">';
        $html .= '<div class="row">';
        $html .= '<div class="col-xs-6" style="font-size: 11px;">';
        if ($dateFrom != null) {
            $html .= $dateFrom->format('d-m-Y');
        } else {
            $html .= "...";
        }
        $html .= '</div>';

        $html .= '<div class="col-xs-6 text-right" style="font-size: 11px;">';
        if ($dateTo != null) {
            $html .= $dateTo->format('d-m-Y');
        } else {
            $html .= "...";
        }
        $html .= '</div>';

        $html .= '</div>';

        $html .= '<div class="progress-month ' . $class . '" style="height: 10px; margin-bottom: 0;">';
        for ($i = 1; $i <= 30; $i++) {
            $html .= '<div class="day-m">';
            $html .= '</div>';
        }
        $html .= '</div>';
        $html .= '<div class="progress-month-left ' . $class . '">';
        if ((30 - $left) > 0) {
            for ($i = 1; $i <= (30 - $left); $i++) {
                $html .= '<div class="day-m-left">';
                $html .= '</div>';
            }
        }


        $html .= '</div>';
        $html .= '</div>';
        return $html;
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
}