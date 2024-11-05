<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="package_product")
 */
class PackageProduct
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime")
     */
    private $dateCreate;


    // product
    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $product;

    // product Name
    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productName;


    /**
     * @var float|null
     * @ORM\Column(type="float")
     */
    private $pricePerAdult;

    // price per children
    /**
     * @var float|null
     * @ORM\Column(type="float")
     */
    private $pricePerChild;


    // booking
    /**
     * @ORM\ManyToOne(targetEntity="Package")
     * @ORM\JoinColumn(name="package_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $package;

    public function __construct()
    {
        $this->dateCreate = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateCreate(): ?\DateTime
    {
        return $this->dateCreate;
    }

    /**
     * @param \DateTime|null $dateCreate
     */
    public function setDateCreate(?\DateTime $dateCreate): void
    {
        $this->dateCreate = $dateCreate;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }

    /**
     * @return string|null
     */
    public function getProductName(): ?string
    {
        return $this->productName;
    }

    /**
     * @param string|null $productName
     */
    public function setProductName(?string $productName): void
    {
        $this->productName = $productName;
    }

    /**
     * @return float|null
     */
    public function getPricePerAdult(): ?float
    {
        return $this->pricePerAdult;
    }

    /**
     * @param float|null $pricePerAdult
     */
    public function setPricePerAdult(?float $pricePerAdult): void
    {
        $this->pricePerAdult = $pricePerAdult;
    }

    /**
     * @return float|null
     */
    public function getPricePerChild(): ?float
    {
        return $this->pricePerChild;
    }

    /**
     * @param float|null $pricePerChild
     */
    public function setPricePerChild(?float $pricePerChild): void
    {
        $this->pricePerChild = $pricePerChild;
    }

    /**
     * @return mixed
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @param mixed $package
     */
    public function setPackage($package): void
    {
        $this->package = $package;
    }

    public function getLetterName(): ?string
    {
        return $this->getProduct()->getLetterName();

    }







}
