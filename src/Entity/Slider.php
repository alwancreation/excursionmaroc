<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Cities
 * @ORM\Entity
 * @ORM\Table(name="slider")
 */
class Slider
{
    /**
     * @var integer
     *
     * @ORM\Column(name="slider_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $sliderId;

    /**
     * @var string
     *
     * @ORM\Column(name="slider_name", type="string", length=255, nullable=true)
     */
    private $sliderName;

    /**
     * @var string
     *
     * @ORM\Column(name="slider_title", type="string", length=255, nullable=true)
     */
    private $sliderTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="slider_description", type="text", nullable=true)
     */
    private $sliderDescription;

    /**
     * @return int
     */
    public function getSliderId()
    {
        return $this->sliderId;
    }
    
    /**
     * @param int $sliderId
     */
    public function setSliderId($sliderId)
    {
        $this->sliderId = $sliderId;
    }

    /**
     * @return string
     */
    public function getSliderName()
    {
        return $this->sliderName;
    }

    /**
     * @param string $sliderName
     */
    public function setSliderName($sliderName)
    {
        $this->sliderName = $sliderName;
    }

    /**
     * @return string
     */
    public function getSliderTitle()
    {
        return $this->sliderTitle;
    }

    /**
     * @param string $sliderTitle
     */
    public function setSliderTitle($sliderTitle)
    {
        $this->sliderTitle = $sliderTitle;
    }

    /**
     * @return string
     */
    public function getSliderDescription()
    {
        return $this->sliderDescription;
    }

    /**
     * @param string $sliderDescription
     */
    public function setSliderDescription($sliderDescription)
    {
        $this->sliderDescription = $sliderDescription;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * @param Asset $asset
     * @return $this
     */
    public function addAsset(Asset $asset)
    {
        $this->assets->add($asset);
        return $this;
    }

    /**
     * @param Asset $asset
     * @return $this
     */
    public function removeAsset(Asset $asset)
    {
        $this->assets->removeElement($asset);
        return $this;
    }



    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Asset", inversedBy="sliders", cascade={"persist"})
     * @ORM\JoinTable(name="slider_has_asset",
     *   joinColumns={
     *     @ORM\JoinColumn(name="slider_id", referencedColumnName="slider_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="asset_id", referencedColumnName="asset_id", onDelete="cascade")
     *   }
     * )
     */
    private $assets;





    function __toString()
    {
        return $this->sliderName;
    }



}
