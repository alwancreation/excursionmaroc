<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Theme
 *
 * @ORM\Table(name="theme")
 * @ORM\Entity
 */
class Theme
{
    /**
     * @var integer
     *
     * @ORM\Column(name="theme_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $themeId;

    /**
     * @var string
     *
     * @ORM\Column(name="theme_name", type="string", length=255, nullable=true)
     */
    private $themeName;


    /**
     * @var string
     *
     * @ORM\Column(name="theme_short_description", type="text", length=65535, nullable=true)
     */
    private $themeShortDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="theme_long_description", type="text", length=65535, nullable=true)
     */
    private $themeLongDescription;









    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Asset", inversedBy="themes", cascade={"persist"})
     * @ORM\JoinTable(name="theme_has_asset",
     *   joinColumns={
     *     @ORM\JoinColumn(name="theme_id", referencedColumnName="theme_id", onDelete="cascade")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="asset_id", referencedColumnName="asset_id", onDelete="cascade")
     *   }
     * )
     */
    private $assets;

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * @param Asset $asset
     * @internal param \Doctrine\Common\Collections\Collection $assets
     */
    public function addAsset(Asset $asset)
    {
        $this->assets->add($asset);
    }

    public function removeAsset(Asset $asset)
    {
        $this->assets->removeElement($asset);
    }
    private $mainAsset;

    /**
     * @return mixed
     */
    public function getMainAsset()
    {
        if($this->assets->count()>0){
            /** @var Asset $asset */
            foreach ($this->assets as $asset){
                if($asset->getAssetIsMain()){
                    return $asset;
                }
            }
            return $this->assets->get(0);
        }
        return null;
    }


    /**
     * Get themeId
     *
     * @return integer
     */
    public function getThemeId()
    {
        return $this->themeId;
    }

    /**
     * Set themeName
     *
     * @param string $themeName
     *
     * @return Theme
     */
    public function setThemeName($themeName)
    {
        $this->themeName = $themeName;

        return $this;
    }

    /**
     * Get themeName
     *
     * @return string
     */
    public function getThemeName()
    {
        return $this->themeName;
    }

    /**
     * Set themeShortDescription
     *
     * @param string $themeShortDescription
     *
     * @return Theme
     */
    public function setThemeShortDescription($themeShortDescription)
    {
        $this->themeShortDescription = $themeShortDescription;

        return $this;
    }

    /**
     * Get themeShortDescription
     *
     * @return string
     */
    public function getThemeShortDescription()
    {
        return $this->themeShortDescription;
    }

    /**
     * Set themeLongDescription
     *
     * @param string $themeLongDescription
     *
     * @return Theme
     */
    public function setThemeLongDescription($themeLongDescription)
    {
        $this->themeLongDescription = $themeLongDescription;

        return $this;
    }

    /**
     * Get themeLongDescription
     *
     * @return string
     */
    public function getThemeLongDescription()
    {
        return $this->themeLongDescription;
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


    function __toString()
    {
        return $this->themeName;
    }
}
