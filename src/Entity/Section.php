<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Product
 *
 * @ORM\Table(name="section")
 * @ORM\Entity
 */
class Section
{
    /**
     * @var integer
     *
     * @ORM\Column(name="section_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $sectionId;

    /**
     * @var string
     *
     * @ORM\Column(name="section_title", type="string", length=255, nullable=true)
     */
    private $sectionTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="section_sub_title", type="string", length=255, nullable=true)
     */
    private $sectionSubTitle;


    /**
     * @var \App\Entity\Page
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Page")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="page_id", referencedColumnName="page_id")
     * })
     */
    private $page;


    /**
     * @var string
     *
     * @ORM\Column(name="section_description", type="text", length=65535, nullable=true)
     */
    private $sectionDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="section_order", type="integer", nullable=true)
     */
    private $sectionOrder;

    /**
     * @var integer
     *
     * @ORM\Column(name="section_type", type="integer", nullable=true)
     */
    private $sectionType;

    /**
     * @return int
     */
    public function getSectionType()
    {
        return $this->sectionType;
    }

    /**
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param Page $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @param int $sectionType
     */
    public function setSectionType($sectionType)
    {
        $this->sectionType = $sectionType;
    }


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Asset",cascade={"persist"})
     * @ORM\JoinTable(name="section_has_asset",
     *   joinColumns={
     *     @ORM\JoinColumn(name="section_id", referencedColumnName="section_id", onDelete="cascade")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="asset_id", referencedColumnName="asset_id", onDelete="cascade")
     *   }
     * )
     */
    private $assets;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Product",cascade={"persist"})
     * @ORM\JoinTable(name="section_has_product",
     *   joinColumns={
     *     @ORM\JoinColumn(name="section_id", referencedColumnName="section_id", onDelete="cascade")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", onDelete="cascade")
     *   }
     * )
     */
    private $products;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Theme",cascade={"persist"})
     * @ORM\JoinTable(name="section_has_theme",
     *   joinColumns={
     *     @ORM\JoinColumn(name="section_id", referencedColumnName="section_id", onDelete="cascade")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="theme_id", referencedColumnName="theme_id", onDelete="cascade")
     *   }
     * )
     */
    private $themes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Destination",cascade={"persist"})
     * @ORM\JoinTable(name="section_has_destination",
     *   joinColumns={
     *     @ORM\JoinColumn(name="section_id", referencedColumnName="section_id", onDelete="cascade")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="destination_id", referencedColumnName="destination_id", onDelete="cascade")
     *   }
     * )
     */
    private $destinations;

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
     * @return int
     */
    public function getSectionId()
    {
        return $this->sectionId;
    }

    /**
     * @param int $sectionId
     */
    public function setSectionId($sectionId)
    {
        $this->sectionId = $sectionId;
    }



    /**
     * @return string
     */
    public function getSectionTitle()
    {
        return $this->sectionTitle;
    }

    /**
     * @param string $sectionTitle
     */
    public function setSectionTitle($sectionTitle)
    {
        $this->sectionTitle = $sectionTitle;
    }

    /**
     * @return string
     */
    public function getSectionSubTitle()
    {
        return $this->sectionSubTitle;
    }

    /**
     * @param string $sectionSubTitle
     */
    public function setSectionSubTitle($sectionSubTitle)
    {
        $this->sectionSubTitle = $sectionSubTitle;
    }

    /**
     * @return string
     */
    public function getSectionDescription()
    {
        return $this->sectionDescription;
    }

    /**
     * @param string $sectionDescription
     */
    public function setSectionDescription($sectionDescription)
    {
        $this->sectionDescription = $sectionDescription;
    }

    /**
     * @return int
     */
    public function getSectionOrder()
    {
        return $this->sectionOrder;
    }

    /**
     * @param int $sectionOrder
     */
    public function setSectionOrder($sectionOrder)
    {
        $this->sectionOrder = $sectionOrder;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $assets
     */
    public function setAssets($assets)
    {
        $this->assets = $assets;
    }

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
    public function addAsset(Asset $asset){
        $this->assets->add($asset);
        return $this;
    }

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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDestinations()
    {
        return $this->destinations;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $destinations
     */
    public function setDestinations($destinations)
    {
        $this->destinations = $destinations;
    }
    
    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $themes
     */
    public function setThemes($themes)
    {
        $this->themes = $themes;
    }


    /**
     * @var boolean
     */
    private $removeAsset;

    /**
     * @return mixed
     */
    public function getRemoveAsset()
    {
        return $this->removeAsset;
    }

    /**
     * @param mixed $removeAsset
     */
    public function setRemoveAsset($removeAsset)
    {
        $this->removeAsset = $removeAsset;
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
