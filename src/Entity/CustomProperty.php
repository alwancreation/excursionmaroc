<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="custom_property")
 * @ORM\Entity
 */
class CustomProperty
{
    /**
     * @var integer
     *
     * @ORM\Column(name="custom_property_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $customPropertyId;

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
     * @var string
     *
     * @ORM\Column(name="custom_property_name", type="text", length=65535, nullable=true)
     */
    private $customPropertyName;
    /**
     * @var string
     *
     * @ORM\Column(name="custom_property_description", type="text", length=65535, nullable=true)
     */
    private $customPropertyDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="custom_property_order", type="integer", nullable=true)
     */
    private $customPropertyOrder;

    /**
     * @var integer
     *
     * @ORM\Column(name="custom_property_type", type="integer", nullable=true)
     */
    private $customPropertyType;

    /**
     * CustomProperty constructor.
     * @param int $customPropertyId
     */
    public function __construct()
    {
        $this->customPropertyOrder = 0;
        $this->customPropertyType = 1;
    }


    /**
     * @return int
     */
    public function getCustomPropertyId()
    {
        return $this->customPropertyId;
    }

    /**
     * @param int $customPropertyId
     */
    public function setCustomPropertyId($customPropertyId)
    {
        $this->customPropertyId = $customPropertyId;
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
     * @return string
     */
    public function getCustomPropertyName()
    {
        return $this->customPropertyName;
    }

    /**
     * @param string $customPropertyName
     */
    public function setCustomPropertyName($customPropertyName)
    {
        $this->customPropertyName = $customPropertyName;
    }

    /**
     * @return string
     */
    public function getCustomPropertyDescription()
    {
        return $this->customPropertyDescription;
    }

    /**
     * @param string $customPropertyDescription
     */
    public function setCustomPropertyDescription($customPropertyDescription)
    {
        $this->customPropertyDescription = $customPropertyDescription;
    }

    /**
     * @return int
     */
    public function getCustomPropertyOrder()
    {
        return $this->customPropertyOrder;
    }

    /**
     * @param int $customPropertyOrder
     */
    public function setCustomPropertyOrder($customPropertyOrder)
    {
        $this->customPropertyOrder = $customPropertyOrder;
    }

    /**
     * @return int
     */
    public function getCustomPropertyType()
    {
        return $this->customPropertyType;
    }

    /**
     * @param int $customPropertyType
     */
    public function setCustomPropertyType($customPropertyType)
    {
        $this->customPropertyType = $customPropertyType;
    }


}
