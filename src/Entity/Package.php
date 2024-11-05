<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="package")
 */
class Package
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // date create
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateCreate;

    // name
    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var float|null
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

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
     * @return \DateTime
     */
    public function getDateCreate(): \DateTime
    {
        return $this->dateCreate;
    }

    /**
     * @param \DateTime $dateCreate
     */
    public function setDateCreate(\DateTime $dateCreate): void
    {
        $this->dateCreate = $dateCreate;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    public function __construct()
    {
        $this->dateCreate = new \DateTime();
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->guides = new \Doctrine\Common\Collections\ArrayCollection();

    }




    // products
    /**
     * @ORM\OneToMany(targetEntity="PackageProduct", mappedBy="package")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="PackageGuide", mappedBy="package")
     */
    private $guides;

    /**
     * @return mixed
     */
    public function getGuides()
    {
        return $this->guides;
    }

    /**
     * @param mixed $guides
     */
    public function setGuides($guides): void
    {
        $this->guides = $guides;
    }

    // add guide
    public function addGuide($guide)
    {
        $this->guides->add($guide);
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }



    /**
     * @param mixed $products
     */
    public function setProducts($products): void
    {
        $this->products = $products;
    }

    public function getAccommodationProducts()
    {
        return $this->getProductsType('accommodation');
    }
    public function getTransferProducts()
    {
        return $this->getProductsType('transfer');
    }
    public function getActivitiesProducts()
    {
        return $this->getProductsType('activity');
    }
    public function getOtherProducts()
    {
        return $this->getProductsType('other');
    }
    public function getTransportProducts()
    {
        return $this->getProductsType('transport');
    }
//    tour
//    restaurant

    public function getTourProducts()
    {
        return $this->getProductsType('tour');
    }

    public function getRestaurantProducts()
    {
        return $this->getProductsType('restaurant');
    }

    public function getMonumentProducts()
    {
        return $this->getProductsType('monument');
    }




    public function getProductsType($type)
    {
        return $this->products->filter(function($product) use ($type){
            return $product->getProduct()->getType() == $type;
        });
    }




    // to string
    public function __toString()
    {
        return $this->name.'';
    }

}
