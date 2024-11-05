<?php

namespace App\Entity;

use App\Entity\Settings;

class ModelSettings
{
    // general
    var $application_name;
    var $application_email;
    var $application_url;
    var $application_description;

    // social
    var $facebook_url;
    var $twitter_url;
    var $linkedin_url;
    var $youtube_url;
    var $google_plus_url;
    var $pinterest_url;
    var $instagram_url;

    // content
    var $default_language;
    var $default_devise;

    public function parse($lines){
        /** @var Settings $line */
        foreach ($lines as $line){
            $this->{$line->getSettingKey()} = $line->getSettingValue();
        }
    }

    /**
     * @return mixed
     */
    public function getDefaultLanguage()
    {
        return $this->default_language;
    }

    /**
     * @param mixed $default_language
     */
    public function setDefaultLanguage($default_language)
    {
        $this->default_language = $default_language;
    }

    /**
     * @return mixed
     */
    public function getDefaultDevise()
    {
        return $this->default_devise;
    }

    /**
     * @param mixed $default_devise
     */
    public function setDefaultDevise($default_devise)
    {
        $this->default_devise = $default_devise;
    }




    /**
     * @return mixed
     */
    public function getApplicationName()
    {
        return $this->application_name;
    }

    /**
     * @param mixed $application_name
     */
    public function setApplicationName($application_name)
    {
        $this->application_name = $application_name;
    }

    /**
     * @return mixed
     */
    public function getApplicationEmail()
    {
        return $this->application_email;
    }

    /**
     * @param mixed $application_email
     */
    public function setApplicationEmail($application_email)
    {
        $this->application_email = $application_email;
    }

    /**
     * @return mixed
     */
    public function getApplicationUrl()
    {
        return $this->application_url;
    }

    /**
     * @param mixed $application_url
     */
    public function setApplicationUrl($application_url)
    {
        $this->application_url = $application_url;
    }

    /**
     * @return mixed
     */
    public function getApplicationDescription()
    {
        return $this->application_description;
    }

    /**
     * @param mixed $application_description
     */
    public function setApplicationDescription($application_description)
    {
        $this->application_description = $application_description;
    }

    /**
     * @return mixed
     */
    public function getFacebookUrl()
    {
        return $this->facebook_url;
    }

    /**
     * @param mixed $facebook_url
     */
    public function setFacebookUrl($facebook_url)
    {
        $this->facebook_url = $facebook_url;
    }

    /**
     * @return mixed
     */
    public function getTwitterUrl()
    {
        return $this->twitter_url;
    }

    /**
     * @param mixed $twitter_url
     */
    public function setTwitterUrl($twitter_url)
    {
        $this->twitter_url = $twitter_url;
    }

    /**
     * @return mixed
     */
    public function getLinkedinUrl()
    {
        return $this->linkedin_url;
    }

    /**
     * @param mixed $linkedin_url
     */
    public function setLinkedinUrl($linkedin_url)
    {
        $this->linkedin_url = $linkedin_url;
    }

    /**
     * @return mixed
     */
    public function getYoutubeUrl()
    {
        return $this->youtube_url;
    }

    /**
     * @param mixed $youtube_url
     */
    public function setYoutubeUrl($youtube_url)
    {
        $this->youtube_url = $youtube_url;
    }

    /**
     * @return mixed
     */
    public function getGooglePlusUrl()
    {
        return $this->google_plus_url;
    }

    /**
     * @param mixed $google_plus_url
     */
    public function setGooglePlusUrl($google_plus_url)
    {
        $this->google_plus_url = $google_plus_url;
    }

    /**
     * @return mixed
     */
    public function getPinterestUrl()
    {
        return $this->pinterest_url;
    }

    /**
     * @param mixed $pinterest_url
     */
    public function setPinterestUrl($pinterest_url)
    {
        $this->pinterest_url = $pinterest_url;
    }

    /**
     * @return mixed
     */
    public function getInstagramUrl()
    {
        return $this->instagram_url;
    }

    /**
     * @param mixed $instagram_url
     */
    public function setInstagramUrl($instagram_url)
    {
        $this->instagram_url = $instagram_url;
    }



}

