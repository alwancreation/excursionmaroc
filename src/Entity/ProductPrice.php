<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Price
 *
 * @ORM\Table(name="product_price")
 * @ORM\Entity
 */
class ProductPrice
{
    /**
     * @var integer
     *
     * @ORM\Column(name="product_price_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $productPriceId;

    /**
     * @var \App\Entity\Product
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="product_id")
     * })
     */
    private $product;

    /**
     * @var \App\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */

    private $user;

    /**
     * @var double
     *
     * @ORM\Column(name="price_1", type="float", nullable=true)
     */
    private $price1;

    /**
     * @var double
     *
     * @ORM\Column(name="price_2", type="float", nullable=true)
     */
    private $price2;

    /**
     * @var double
     *
     * @ORM\Column(name="price_3", type="float", nullable=true)
     */
    private $price3;

    /**
     * @var double
     *
     * @ORM\Column(name="price_4", type="float", nullable=true)
     */
    private $price4;

    /**
     * @var double
     *
     * @ORM\Column(name="price_5", type="float", nullable=true)
     */
    private $price5;

    /**
     * @var double
     *
     * @ORM\Column(name="price_6", type="float", nullable=true)
     */
    private $price6;

    /**
     * @var double
     *
     * @ORM\Column(name="price_7", type="float", nullable=true)
     */
    private $price7;

    /**
     * @var double
     *
     * @ORM\Column(name="price_8", type="float", nullable=true)
     */
    private $price8;

    /**
     * @var double
     *
     * @ORM\Column(name="price_9", type="float", nullable=true)
     */
    private $price9;

    /**
     * @var double
     *
     * @ORM\Column(name="price_10", type="float", nullable=true)
     */
    private $price10;

    /**
     * @var double
     *
     * @ORM\Column(name="price_11", type="float", nullable=true)
     */
    private $price11;

    /**
     * @var double
     *
     * @ORM\Column(name="price_12", type="float", nullable=true)
     */
    private $price12;

    /**
     * @var double
     *
     * @ORM\Column(name="price_13", type="float", nullable=true)
     */
    private $price13;

    /**
     * @var double
     *
     * @ORM\Column(name="price_14", type="float", nullable=true)
     */
    private $price14;

    /**
     * @var double
     *
     * @ORM\Column(name="price_14_plus", type="float", nullable=true)
     */
    private $price14Plus;
    /**
     * @var double
     *
     * @ORM\Column(name="child_reduction", type="float", nullable=true)
     */
    private $childReduction;

    /**
     * @return float
     */
    public function getChildReduction()
    {
        return $this->childReduction;
    }

    /**
     * @param float $childReduction
     */
    public function setChildReduction($childReduction)
    {
        $this->childReduction = $childReduction;
    }


    /**
     * @return int
     */
    public function getProductPriceId()
    {
        return $this->productPriceId;
    }

    /**
     * @param int $productPriceId
     */
    public function setProductPriceId($productPriceId)
    {
        $this->productPriceId = $productPriceId;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return float
     */
    public function getPrice1()
    {
        return $this->price1;
    }

    /**
     * @param float $price1
     */
    public function setPrice1($price1)
    {
        $this->price1 = $price1;
    }

    /**
     * @return float
     */
    public function getPrice2()
    {
        return $this->price2;
    }

    /**
     * @param float $price2
     */
    public function setPrice2($price2)
    {
        $this->price2 = $price2;
    }

    /**
     * @return float
     */
    public function getPrice3()
    {
        return $this->price3;
    }

    /**
     * @param float $price3
     */
    public function setPrice3($price3)
    {
        $this->price3 = $price3;
    }

    /**
     * @return float
     */
    public function getPrice4()
    {
        return $this->price4;
    }

    /**
     * @param float $price4
     */
    public function setPrice4($price4)
    {
        $this->price4 = $price4;
    }

    /**
     * @return float
     */
    public function getPrice5()
    {
        return $this->price5;
    }

    /**
     * @param float $price5
     */
    public function setPrice5($price5)
    {
        $this->price5 = $price5;
    }

    /**
     * @return float
     */
    public function getPrice6()
    {
        return $this->price6;
    }

    /**
     * @param float $price6
     */
    public function setPrice6($price6)
    {
        $this->price6 = $price6;
    }

    /**
     * @return float
     */
    public function getPrice7()
    {
        return $this->price7;
    }

    /**
     * @param float $price7
     */
    public function setPrice7($price7)
    {
        $this->price7 = $price7;
    }

    /**
     * @return float
     */
    public function getPrice8()
    {
        return $this->price8;
    }

    /**
     * @param float $price8
     */
    public function setPrice8($price8)
    {
        $this->price8 = $price8;
    }

    /**
     * @return float
     */
    public function getPrice9()
    {
        return $this->price9;
    }

    /**
     * @param float $price9
     */
    public function setPrice9($price9)
    {
        $this->price9 = $price9;
    }

    /**
     * @return float
     */
    public function getPrice10()
    {
        return $this->price10;
    }

    /**
     * @param float $price10
     */
    public function setPrice10($price10)
    {
        $this->price10 = $price10;
    }

    /**
     * @return float
     */
    public function getPrice11()
    {
        return $this->price11;
    }

    /**
     * @param float $price11
     */
    public function setPrice11($price11)
    {
        $this->price11 = $price11;
    }

    /**
     * @return float
     */
    public function getPrice12()
    {
        return $this->price12;
    }

    /**
     * @param float $price12
     */
    public function setPrice12($price12)
    {
        $this->price12 = $price12;
    }

    /**
     * @return float
     */
    public function getPrice13()
    {
        return $this->price13;
    }

    /**
     * @param float $price13
     */
    public function setPrice13($price13)
    {
        $this->price13 = $price13;
    }

    /**
     * @return float
     */
    public function getPrice14()
    {
        return $this->price14;
    }

    /**
     * @param float $price14
     */
    public function setPrice14($price14)
    {
        $this->price14 = $price14;
    }

    /**
     * @return float
     */
    public function getPrice14Plus()
    {
        return $this->price14Plus;
    }

    /**
     * @param float $price14Plus
     */
    public function setPrice14Plus($price14Plus)
    {
        $this->price14Plus = $price14Plus;
    }



}
