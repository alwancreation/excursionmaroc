<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Destination
 *
 * @ORM\Table(name="destination", indexes={@ORM\Index(name="destination_name", columns={"destination_name"}), @ORM\Index(name="destination_category_id", columns={"destination_category_id"}), @ORM\Index(name="destination_icon_id", columns={"destination_icon_id"})})
 * @ORM\Entity
 */
class Destination
{
    /**
     * @var integer
     *
     * @ORM\Column(name="destination_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $destinationId;

    /**
     * @var string
     *
     * @ORM\Column(name="destination_name", type="string", length=255, nullable=true)
     */
    private $destinationName;

    /**
     * @var string
     *
     * @ORM\Column(name="destination_slug", type="string", length=255, nullable=true)
     */
     private $destinationSlug;


/**
 * @Assert\File(maxSize="6000000000000")
 */
private $assetFile;
/**
 * @return mixed
 */
public function getAssetFile()
{
    return $this->assetFile;
}
/**
 * @param mixed $assetFile
 */
public function setAssetFile($assetFile)
{
    $this->assetFile = $assetFile;
}

    /**
     * @var \App\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destination_category_id", referencedColumnName="category_id")
     * })
     */
    private $destinationCategory;

    /**
     * @var \App\Entity\Asset
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Asset")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destination_icon_id", referencedColumnName="asset_id")
     * })
     */
    private $destinationIcon;



    /**
     * Get destinationId
     *
     * @return integer
     */
    public function getDestinationId()
    {
        return $this->destinationId;
    }

    /**
     * Set destinationName
     *
     * @param string $destinationName
     *
     * @return Destination
     */
    public function setDestinationName($destinationName)
    {
        $this->destinationName = $destinationName;

        return $this;
    }

    /**
     * Get destinationName
     *
     * @return string
     */
    public function getDestinationName()
    {
        return $this->destinationName;
    }

    /**
     * Set destinationCategory
     *
     * @param \App\Entity\Category $destinationCategory
     *
     * @return Destination
     */
    public function setDestinationCategory(\App\Entity\Category $destinationCategory = null)
    {
        $this->destinationCategory = $destinationCategory;

        return $this;
    }

    /**
     * Get destinationCategory
     *
     * @return \App\Entity\Category
     */
    public function getDestinationCategory()
    {
        return $this->destinationCategory;
    }

    /**
     * Set destinationIcon
     *
     * @param \App\Entity\Asset $destinationIcon
     *
     * @return Destination
     */
    public function setDestinationIcon(\App\Entity\Asset $destinationIcon = null)
    {
        $this->destinationIcon = $destinationIcon;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDestinationSlug()
    {
        return $this->destinationSlug;
    }

    /**
     * @param mixed $destinationSlug
     */
    public function setDestinationSlug($destinationSlug)
    {
        $this->destinationSlug = $destinationSlug;
    }



    /**
     * @var \App\Entity\Asset
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Asset",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="asset_id", referencedColumnName="asset_id")
     * })
     */
    private $mainAsset;
    /**
     * @return Asset
     */
    public function getMainAsset()
    {
        return $this->mainAsset;
    }

    /**
     * @param Asset $mainAsset
     */
    public function setMainAsset($mainAsset)
    {
        $this->mainAsset = $mainAsset;
    }

    /**
     * Get destinationIcon
     *
     * @return \App\Entity\Asset
     */
    public function getDestinationIcon()
    {
        return $this->destinationIcon;
    }

    function __toString()
    {
        return $this->destinationName;
    }


}
