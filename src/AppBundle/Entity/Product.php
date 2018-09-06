<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="destination_id", columns={"destination_id"}), @ORM\Index(name="category_id", columns={"category_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="product_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $productId;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=255, nullable=true)
     */
    private $productName;
    /**
     * @var string
     *
     * @ORM\Column(name="product_slug", type="string", length=255, nullable=true)
     */
    private $productSlug;



    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Theme",cascade={"persist"})
     * @ORM\JoinTable(name="product_has_theme",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", onDelete="cascade")
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Destination",cascade={"persist"})
     * @ORM\JoinTable(name="product_has_destination",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", onDelete="cascade")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="destination_id", referencedColumnName="destination_id", onDelete="cascade")
     *   }
     * )
     */
    private $destinations;


    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", length=255, nullable=true)
     */
    private $duration;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_private", type="boolean", nullable=true)
     */
    private $private;


    /**
     * @var string
     *
     * @ORM\Column(name="difficulty", type="string", length=255, nullable=true)
     */
    private $difficulty;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_persons", type="integer", nullable=true)
     */
    private $maxPersons;

    /**
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param string $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return boolean
     */
    public function isPrivate()
    {
        return $this->private;
    }

    /**
     * @param boolean $private
     */
    public function setPrivate($private)
    {
        $this->private = $private;
    }

    /**
     * @return string
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * @param string $difficulty
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;
    }

    /**
     * @return int
     */
    public function getMaxPersons()
    {
        return $this->maxPersons;
    }

    /**
     * @param int $maxPersons
     */
    public function setMaxPersons($maxPersons)
    {
        $this->maxPersons = $maxPersons;
    }



    /**
     * @var \AppBundle\Entity\Agency
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Agency")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agency", referencedColumnName="id", onDelete="cascade")
     * })
     */
    private $agency;

    public function __construct()
    {
        $this->destinations = new ArrayCollection();
        $this->themes = new ArrayCollection();
    }


    /**
     * @return Agency
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * @param Agency $agency
     */
    public function setAgency($agency)
    {
        $this->agency = $agency;
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
     * @param Destination $destination
     */
    public function addDestination(Destination $destination)
    {
        $this->destinations->add($destination);
    }

    /**
     * @param Destination $destination
     */
    public function removeDestination(Destination $destination)
    {
        $this->destinations->removeElement($destination);
    }

    /**
     * @param Theme $theme
     */
    public function addTheme(Theme $theme)
    {
        $this->themes->add($theme);
    }

    /**
     * @param Theme $theme
     */
    public function removeTheme(Theme $theme)
    {
        $this->themes->removeElement($theme);
    }




    /**
     * @return string
     */
    public function getProductSlug()
    {
        return $this->productSlug;
    }

    /**
     * @param string $productSlug
     */
    public function setProductSlug($productSlug)
    {
        $this->productSlug = $productSlug;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="product_duration", type="string", length=255, nullable=true)
     */
    private $productDuration;


    /**
     * @var string
     *
     * @ORM\Column(name="product_short_description", type="text", length=65535, nullable=true)
     */
    private $productShortDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="product_video_html", type="text", length=65535, nullable=true)
     */
    private $productVideoHtml;
    /**
     * @var string
     *
     * @ORM\Column(name="product_map_html", type="text", length=65535, nullable=true)
     */
    private $productMapHtml;

    /**
     * @return string
     */
    public function getProductVideoHtml()
    {
        return $this->productVideoHtml;
    }

    /**
     * @param string $productVideoHtml
     */
    public function setProductVideoHtml($productVideoHtml)
    {
        $this->productVideoHtml = $productVideoHtml;
    }

    /**
     * @return string
     */
    public function getProductMapHtml()
    {
        return $this->productMapHtml;
    }

    /**
     * @param string $productMapHtml
     */
    public function setProductMapHtml($productMapHtml)
    {
        $this->productMapHtml = $productMapHtml;
    }



    /**
     * @var string
     *
     * @ORM\Column(name="product_long_description", type="text", length=65535, nullable=true)
     */
    private $productLongDescription;


    /**
     * @var double
     *
     * @ORM\Column(name="product_price", type="float", nullable=true)
     */
    private $productPrice;

    /**
     * @return float
     */
    public function getProductPrice()
    {
        return $this->productPrice;
    }

    /**
     * @param float $productPrice
     */
    public function setProductPrice($productPrice)
    {
        $this->productPrice = $productPrice;
    }

    /**
     * @return string
     */
    public function getProductDuration()
    {
        return $this->productDuration;
    }

    /**
     * @param string $productDuration
     */
    public function setProductDuration($productDuration)
    {
        $this->productDuration = $productDuration;
    }



    /**
     * @var ProductPrice
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ProductPrice", mappedBy="product")
     */
    private $prices;

    /**
     * @return ProductPrice
     */
    public function getPrices()
    {
        return $this->prices;
    }
    public function getPrice($adults = 2, $childs=0){
        $priceLine =$this->getPrices();
        if($priceLine){
            if($adults<=14) {
                $price = null;
                for ($a = 1; $a <= 14; $a++) {
                    if ($adults == $a) {
                        for ($i = $a; $i >= 1; $i--) {
                            eval('if($priceLine->getPrice' . $i . '() && $price===null){$price = $priceLine->getPrice' . $i . '();};');
                        }
                    }
                }
                if($price!==null){
                    return $price;
                }
            }

            if($adults>14){
                $price = null;
                eval('if($priceLine->getPrice14Plus()){$price = $priceLine->getPrice14Plus();};');
                for($i=14;$i>=1;$i--){
                    eval('if($priceLine->getPrice'.$i.'() && $price===null){$price = $priceLine->getPrice'.$i.'();};');
                }
                if($price!==null){
                    return $price;
                }
            }
        }
        return $this->getProductPrice();
    }
    /**
     * @param ProductPrice $prices
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;
    }


    /**
     * @var \AppBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="category_id")
     * })
     */
    private $category;

    /**
     * @var \AppBundle\Entity\Destination
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Destination")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destination_id", referencedColumnName="destination_id")
     * })
     */
    private $destination;

    /**
     * @ORM\OneToMany(targetEntity="CustomProperty", mappedBy="product")
     */
    private $customProperties;

    /**
     * @return mixed
     */
    public function getCustomProperties()
    {
        return $this->customProperties;
    }

    /**
     * @return mixed
     */
    public function getCustomPropertiesType($type=null)
    {
        $props = $this->getCustomProperties();
        $result = [];
        /** @var CustomProperty $prop */
        foreach ($props as $prop){
            if($type == $prop->getCustomPropertyType()){
                $result[] = $prop;
            }
        }
        return $result;
    }

    /**
     * @param mixed $customProperties
     */
    public function setCustomProperties($customProperties)
    {
        $this->customProperties = $customProperties;
    }


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Asset", inversedBy="products", cascade={"persist"})
     * @ORM\JoinTable(name="product_has_asset",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", onDelete="cascade")
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
     * Get productId
     *
     * @return integer
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set productName
     *
     * @param string $productName
     *
     * @return Product
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get productName
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set productShortDescription
     *
     * @param string $productShortDescription
     *
     * @return Product
     */
    public function setProductShortDescription($productShortDescription)
    {
        $this->productShortDescription = $productShortDescription;

        return $this;
    }

    /**
     * Get productShortDescription
     *
     * @return string
     */
    public function getProductShortDescription()
    {
        return $this->productShortDescription;
    }

    /**
     * Set productLongDescription
     *
     * @param string $productLongDescription
     *
     * @return Product
     */
    public function setProductLongDescription($productLongDescription)
    {
        $this->productLongDescription = $productLongDescription;

        return $this;
    }

    /**
     * Get productLongDescription
     *
     * @return string
     */
    public function getProductLongDescription()
    {
        return $this->productLongDescription;
    }


    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set destination
     *
     * @param \AppBundle\Entity\Destination $destination
     *
     * @return Product
     */
    public function setDestination(\AppBundle\Entity\Destination $destination = null)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return \AppBundle\Entity\Destination
     */
    public function getDestination()
    {
        return $this->destination;
    }


    function __toString()
    {
        return $this->productName;
    }

    /**
     * @param $user User
     * @return bool
     */
    public function getAccess($user)
    {
        if($user->hasRole("ROLE_ADMIN")){
            return true;
        }
        if($agency = $this->getAgency()){
            $ua = $agency->getUser();
            if($ua==$user){
               return true;
            }
        }
        return false;
    }



    /**
     * @var \AppBundle\Entity\Asset
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Asset" , cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="attached_file_id", referencedColumnName="asset_id")
     * })
     */
    private $attached;

    /**
     * @return mixed
     */
    public function getAttached()
    {
        return $this->attached;
    }

    /**
     * @param mixed $attached
     */
    public function setAttached($attached)
    {
        $this->attached = $attached;
    }


    /**
     * @Assert\File(maxSize="6000000000000")
     */
    private $attachedFile;

    /**
     * @return mixed
     */
    public function getAttachedFile()
    {
        return $this->attachedFile;
    }

    /**
     * @param mixed $attachedFile
     */
    public function setAttachedFile($attachedFile)
    {
        $this->attachedFile = $attachedFile;
    }
}
