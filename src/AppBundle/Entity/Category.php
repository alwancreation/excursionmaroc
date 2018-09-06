<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category", indexes={@ORM\Index(name="category_icon_id", columns={"category_icon_id"})})
 * @ORM\Entity
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $categoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="category_name", type="string", length=255, nullable=true)
     */
    private $categoryName;

    /**
     * @var string
     *
     * @ORM\Column(name="category_long_description", type="text", length=65535, nullable=true)
     */
    private $categoryLongDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="category_short_description", type="text", length=65535, nullable=true)
     */
    private $categoryShortDescription;

    /**
     * @var \AppBundle\Entity\Asset
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Asset")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_icon_id", referencedColumnName="asset_id")
     * })
     */
    private $categoryIcon;



    /**
     * Get categoryId
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set categoryName
     *
     * @param string $categoryName
     *
     * @return Category
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    /**
     * Get categoryName
     *
     * @return string
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * Set categoryLongDescription
     *
     * @param string $categoryLongDescription
     *
     * @return Category
     */
    public function setCategoryLongDescription($categoryLongDescription)
    {
        $this->categoryLongDescription = $categoryLongDescription;

        return $this;
    }

    /**
     * Get categoryLongDescription
     *
     * @return string
     */
    public function getCategoryLongDescription()
    {
        return $this->categoryLongDescription;
    }

    /**
     * Set categoryShortDescription
     *
     * @param string $categoryShortDescription
     *
     * @return Category
     */
    public function setCategoryShortDescription($categoryShortDescription)
    {
        $this->categoryShortDescription = $categoryShortDescription;

        return $this;
    }

    /**
     * Get categoryShortDescription
     *
     * @return string
     */
    public function getCategoryShortDescription()
    {
        return $this->categoryShortDescription;
    }

    /**
     * Set categoryIcon
     *
     * @param \AppBundle\Entity\Asset $categoryIcon
     *
     * @return Category
     */
    public function setCategoryIcon(\AppBundle\Entity\Asset $categoryIcon = null)
    {
        $this->categoryIcon = $categoryIcon;

        return $this;
    }

    /**
     * Get categoryIcon
     *
     * @return \AppBundle\Entity\Asset
     */
    public function getCategoryIcon()
    {
        return $this->categoryIcon;
    }

    function __toString()
    {
        return $this->categoryName;
    }
}
