<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Asset
 *
 * @ORM\Table(name="asset")
 * @ORM\Entity
 */
class Asset
{
    /**
     * @var integer
     *
     * @ORM\Column(name="asset_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $assetId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="asset_is_main", type="boolean", nullable=true)
     */
    private $assetIsMain;

    /**
     * @var string
     *
     * @ORM\Column(name="asset_base_path", type="string", length=255, nullable=true)
     */
    private $assetBasePath;

    /**
     * @var string
     *
     * @ORM\Column(name="asset_title", type="string", length=255, nullable=true)
     */
    private $assetTitle;
    /**
     * @var string
     *
     * @ORM\Column(name="asset_alt", type="string", length=255, nullable=true)
     */
    private $assetAlt;

    /**
     * @var string
     *
     * @ORM\Column(name="asset_link", type="string", length=255, nullable=true)
     */
    private $assetLink;
    /**
     * @var string
     *
     * @ORM\Column(name="asset_link_title", type="string", length=255, nullable=true)
     */
    private $assetLinkTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="asset_description", type="text", nullable=true)
     */
    private $assetDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="asset_type", type="integer", nullable=true)
     */
    private $assetType;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", mappedBy="assets")
     */
    private $products;

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return string
     */
    public function getAssetTitle()
    {
        return $this->assetTitle;
    }

    /**
     * @param string $assetTitle
     */
    public function setAssetTitle($assetTitle)
    {
        $this->assetTitle = $assetTitle;
    }

    /**
     * @return string
     */
    public function getAssetAlt()
    {
        return $this->assetAlt;
    }

    /**
     * @param string $assetAlt
     */
    public function setAssetAlt($assetAlt)
    {
        $this->assetAlt = $assetAlt;
    }

    /**
     * @return string
     */
    public function getAssetLink()
    {
        return $this->assetLink;
    }

    /**
     * @param string $assetLink
     */
    public function setAssetLink($assetLink)
    {
        $this->assetLink = $assetLink;
    }

    /**
     * @return string
     */
    public function getAssetLinkTitle()
    {
        return $this->assetLinkTitle;
    }

    /**
     * @param string $assetLinkTitle
     */
    public function setAssetLinkTitle($assetLinkTitle)
    {
        $this->assetLinkTitle = $assetLinkTitle;
    }

    /**
     * @return string
     */
    public function getAssetDescription()
    {
        return $this->assetDescription;
    }

    /**
     * @param string $assetDescription
     */
    public function setAssetDescription($assetDescription)
    {
        $this->assetDescription = $assetDescription;
    }




    /**
     * Get assetId
     *
     * @return integer
     */
    public function getAssetId()
    {
        return $this->assetId;
    }

    /**
     * Set assetIsMain
     *
     * @param boolean $assetIsMain
     *
     * @return Asset
     */
    public function setAssetIsMain($assetIsMain)
    {
        $this->assetIsMain = $assetIsMain;

        return $this;
    }

    /**
     * Get assetIsMain
     *
     * @return boolean
     */
    public function getAssetIsMain()
    {
        return $this->assetIsMain;
    }

    /**
     * Set assetBasePath
     *
     * @param string $assetBasePath
     *
     * @return Asset
     */
    public function setAssetBasePath($assetBasePath)
    {
        $this->assetBasePath = $assetBasePath;

        return $this;
    }

    /**
     * Get assetBasePath
     *
     * @return string
     */
    public function getAssetBasePath()
    {
        return $this->assetBasePath;
    }

    /**
     * Set assetType
     *
     * @param integer $assetType
     *
     * @return Asset
     */
    public function setAssetType($assetType)
    {
        $this->assetType = $assetType;

        return $this;
    }

    /**
     * Get assetType
     *
     * @return integer
     */
    public function getAssetType()
    {
        return $this->assetType;
    }



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
}
