<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="destination_id", columns={"destination_id"}), @ORM\Index(name="category_id", columns={"category_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @Gedmo\TranslationEntity(class="App\Entity\Translation\ElementTranslation")
 */
class Product implements Translatable
{
    /**
     * @var integer
     * @ORM\Column(name="product_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $productId;

    /**
     * @return string
     */
    public function getProductTitle()
    {
        return $this->productTitle;
    }

    /**
     * @param string $productTitle
     */
    public function setProductTitle($productTitle)
    {
        $this->productTitle = $productTitle;
    }

    /**
     * @var string
     * @ORM\Column(name="product_name", type="string", length=255, nullable=true)
     */
    private $productName;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="product_title", type="string", length=255, nullable=true)
     */
    private $productTitle;


    /**
     * @var string
     * @Gedmo\Slug(fields={"productName"})
     * @ORM\Column(name="product_slug", type="string", length=255, nullable=true)
     */
    private $productSlug;


    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", length=255, nullable=true)
     */
    private $duration;

    /**
     * @var integer
     *
     * @ORM\Column(name="available_places", type="integer", nullable=true)
     */
    private $availablePlaces;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_private", type="boolean", nullable=true)
     */
    private $private;


    /**
     * @var boolean
     *
     * @ORM\Column(name="is_available", type="boolean", nullable=true)
     */
    private $available;



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
     * @return string
     */
    public function getProductSlug()
    {
        return ($this->productSlug!=null && $this->productSlug!='')?$this->productSlug:$this->getProductId();
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
     * @Gedmo\Translatable
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
     * @Gedmo\Translatable
     * @ORM\Column(name="product_long_description", type="text", length=65535, nullable=true)
     */
    private $productLongDescription;

    /**
     * Page locale
     * Used locale to override Translation listener's locale
     *
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * Sets translatable locale
     *
     * @param string $locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @var double
     *
     * @ORM\Column(name="product_price", type="float", nullable=true)
     */
    private $productPrice;
    /**
     * @var double
     *
     * @ORM\Column(name="product_saint_sylvester_price", type="float", nullable=true)
     */
    private $ProductSaintSylvesterPrice;



    /**
     * @var integer
     *
     * @ORM\Column(name="product_order", type="integer", nullable=true)
     */
    private $productOrder;

    /**
     * @var integer
     *
     * @ORM\Column(name="custom_payment_percent", type="integer", nullable=true)
     */
    private $customPaymentPercent;

    /**
     * @return int
     */
    public function getProductOrder()
    {
        return $this->productOrder;
    }

    /**
     * @param int $productOrder
     */
    public function setProductOrder($productOrder)
    {
        $this->productOrder = $productOrder;
    }



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
     * @ORM\OneToOne(targetEntity="App\Entity\ProductPrice", mappedBy="product")
     */
    private $prices;

    /**
     * @return ProductPrice
     */
    public function getPrices()
    {
        return $this->prices;
    }

    public function __construct()
    {
        $this->destinations = new ArrayCollection();
        $this->themes = new ArrayCollection();
        $this->months = new ArrayCollection();
        $this->assets = new ArrayCollection();
        $this->products = new ArrayCollection();

    }


    public function getPrice($adults = 2, \DateTime $date=null){
        if ($date && $this->getProductSaintSylvesterPrice()){
            if($date->format("d")==31 && $date->format("m")==12){
                return $this->getProductSaintSylvesterPrice();
            }
        }
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
                if($price!==null){
                    return $price;
                }
            }
        }
        return $this->getProductPrice();
    }

    public function getTotalPrice($adults = 2, $children=0,\DateTime $date=null){
        return $this->getPrice($adults,$date)*$adults+$this->getPriceChildren($children,$date)*$children;
    }

    public function getPriceChildren($adults=0,\DateTime $date=null){
        if ($date && $this->getProductSaintSylvesterPrice()){
            if($date->format("d")==31 && $date->format("m")==12){
                $childrenReduction = 50;
                if($this->getPrices() && $this->getPrices()->getChildReduction()>=0 && $this->getPrices()->getChildReduction()<=100){
                    $childrenReduction = $this->getPrices()->getChildReduction();
                }
                return $this->getProductSaintSylvesterPrice() - $this->getProductSaintSylvesterPrice()*$childrenReduction/100;
            }
        }
        $priceLine =$this->getPrices();
        if($priceLine && $this->isPrivate()){
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
                    $childrenReduction = 50;
                    if($priceLine->getChildReduction()>=0){
                        $childrenReduction = $priceLine->getChildReduction();
                    }
                    return $price - ($childrenReduction*$childrenReduction/100);
                }
            }

            if($adults>14){
                $price = null;
                eval('if($priceLine->getPrice14Plus()){$price = $priceLine->getPrice14Plus();};');

                if($price!==null){
                    $childrenReduction = 50;
                    if($priceLine->getChildReduction()>=0){
                        $childrenReduction = $priceLine->getChildReduction();
                    }
                    return $price - ($childrenReduction*$childrenReduction/100);
                }
            }
        }
        if($priceLine){
            $childrenReduction = 50;
            if($priceLine->getChildReduction()>=0){
                $childrenReduction = $priceLine->getChildReduction();
            }
            return $this->getProductPrice() - ($childrenReduction*$childrenReduction/100);
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
     * @var \App\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="category_id")
     * })
     */
    private $category;

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
     * @var \App\Entity\Destination
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Destination")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destination_id", referencedColumnName="destination_id")
     * })
     */
    private $destination;

    /**
     * @var \App\Entity\Destination
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Destination")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destination_from_id", referencedColumnName="destination_id")
     * })
     */
    private $destinationFrom;


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
     * @return Destination
     */
    public function getDestinationFrom()
    {
        return $this->destinationFrom;
    }

    /**
     * @param Destination $destinationFrom
     */
    public function setDestinationFrom($destinationFrom)
    {
        $this->destinationFrom = $destinationFrom;
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Asset", inversedBy="products", cascade={"persist"})
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Product")
     * @ORM\JoinTable(name="related_product",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", onDelete="cascade")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="related_product_id", referencedColumnName="product_id", onDelete="cascade")
     *   }
     * )
     */
    private $products;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Month", cascade={"persist"})
     * @ORM\JoinTable(name="product_in_month",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", onDelete="cascade")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="month_id", referencedColumnName="month_id", onDelete="cascade")
     *   }
     * )
     */
    private $months;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Destination", inversedBy="products", cascade={"persist"})
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Theme", inversedBy="products", cascade={"persist"})
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

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMonths()
    {
        return $this->months;
    }
    /**
     * @param Month $month
     * @internal param \Doctrine\Common\Collections\Collection $months
     */
    public function addMonth(Month $month)
    {
        $this->months->add($month);
    }
    public function removeMonth(Month $month)
    {
        $this->months->removeElement($month);
    }


    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDestinations()
    {
        return $this->destinations;
    }

    /**
     * @ORM\ManyToMany(targetEntity="Section", mappedBy="products")
     **/
    protected $sections;

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
     * @param Destination $destination
     * @internal param \Doctrine\Common\Collections\Collection $destinations
     */
    public function addDestination(Destination $destination)
    {
        $this->destinations->add($destination);
    }

    public function removeDestination(Destination $destination)
    {
        $this->destinations->removeElement($destination);
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
     * @param \App\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\App\Entity\Category $category = null)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Get category
     *
     * @return \App\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set destination
     *
     * @param \App\Entity\Destination $destination
     *
     * @return Product
     */
    public function setDestination(\App\Entity\Destination $destination = null)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return \App\Entity\Destination
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @return int
     */
    public function getAvailablePlaces()
    {
        return $this->availablePlaces;
    }

    /**
     * @param int $availablePlaces
     */
    public function setAvailablePlaces($availablePlaces)
    {
        $this->availablePlaces = $availablePlaces;
    }

    /**
     * @return boolean
     */
    public function isAvailable()
    {
        return $this->available;
    }

    /**
     * @param boolean $available
     */
    public function setAvailable($available)
    {
        $this->available = $available;
    }


    function __toString()
    {
        return $this->productName."";
    }


    /**
     * @var \App\Entity\Asset
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Asset" , cascade={"persist"})
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
     * @return float
     */
    public function getProductSaintSylvesterPrice()
    {
        return $this->ProductSaintSylvesterPrice;
    }

    /**
     * @param float $ProductSaintSylvesterPrice
     */
    public function setProductSaintSylvesterPrice($ProductSaintSylvesterPrice)
    {
        $this->ProductSaintSylvesterPrice = $ProductSaintSylvesterPrice;
    }

    /**
     * @return int
     */
    public function getCustomPaymentPercent()
    {
        return $this->customPaymentPercent;
    }

    /**
     * @param int $customPaymentPercent
     */
    public function setCustomPaymentPercent($customPaymentPercent)
    {
        $this->customPaymentPercent = $customPaymentPercent;
    }



    /**
     * @var \App\Entity\Agency
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Agency")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agency", referencedColumnName="id", onDelete="cascade")
     * })
     */
    private $agency;

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

}
