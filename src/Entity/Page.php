<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Cities
 * @ORM\Entity
 * @ORM\Table(name="page")
 */
class Page
{
    /**
     * @var integer
     *
     * @ORM\Column(name="page_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pageId;

    /**
     * @var string
     *
     * @ORM\Column(name="page_name", type="string", length=150, nullable=true)
     */
    private $pageName;

    /**
     * @var string
     *
     * @ORM\Column(name="page_title", type="string", length=255, nullable=true)
     */
    private $pageTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="page_sub_title", type="string", length=255, nullable=true)
     */
    private $pageSubTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="page_long_description", type="text", nullable=true)
     */
    private $pageLongDescription;
    /**
     * @var string
     *
     * @ORM\Column(name="page_short_description", type="text", nullable=true)
     */
    private $pageShortDescription;

    /**
     * @return string
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * @return string
     */
    public function getPageSubTitle()
    {
        return $this->pageSubTitle;
    }

    /**
     * @param string $pageSubTitle
     */
    public function setPageSubTitle($pageSubTitle)
    {
        $this->pageSubTitle = $pageSubTitle;
    }


    /**
     * @param string $pageTitle
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;
    }

    /**
     * @return string
     */
    public function getPageLongDescription()
    {
        return $this->pageLongDescription;
    }

    /**
     * @param string $pageLongDescription
     */
    public function setPageLongDescription($pageLongDescription)
    {
        $this->pageLongDescription = $pageLongDescription;
    }

    /**
     * @return string
     */
    public function getPageShortDescription()
    {
        return $this->pageShortDescription;
    }

    /**
     * @param string $pageShortDescription
     */
    public function setPageShortDescription($pageShortDescription)
    {
        $this->pageShortDescription = $pageShortDescription;
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


    /**
     * @var \App\Entity\Asset
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Asset" , cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="asset_id", referencedColumnName="asset_id")
     * })
     */
    private $asset;
    /**
     * @var \App\Entity\Meta
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Meta" , cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="meta_id", referencedColumnName="meta_id")
     * })
     */
    private $meta;

    /**
     * @return Meta
     */
    public function getMeta()
    {
        return ($this->meta)?$this->meta:new Meta();
    }

    /**
     * @param Meta $meta
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;
    }


    /**
     * @return int
     */
    public function getPageId()
    {
        return $this->pageId;
    }

    /**
     * @param int $pageId
     */
    public function setPageId($pageId)
    {
        $this->pageId = $pageId;
    }

    /**
     * @return string
     */
    public function getPageName()
    {
        return $this->pageName;
    }

    /**
     * @param string $pageName
     */
    public function setPageName($pageName)
    {
        $this->pageName = $pageName;
    }

    /**
     * @return Asset
     */
    public function getAsset()
    {
        return $this->asset;
    }

    /**
     * @param Asset $asset
     */
    public function setAsset($asset)
    {
        $this->asset = $asset;
    }



    function __toString()
    {
        return $this->pageName;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Section", mappedBy="page")
     * @OrderBy({"sectionOrder" = "ASC"})
     */
    private $sections;

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * @param Section $section
     */
    public function addSections(Section $section)
    {
        $this->sections->add($section);
    }

    /**
     * @param Section $section
     */
    public function removeSection(Section $section)
    {
        $this->sections->removeElement($section);
    }




}
