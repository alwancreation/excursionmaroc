<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Galerie photo dédiée d'une excursion (ordre, texte alternatif SEO, image principale).
 *
 * @ORM\Table(name="excursion_image")
 * @ORM\Entity(repositoryClass="App\Repository\ExcursionImageRepository")
 */
class ExcursionImage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="images")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", onDelete="CASCADE", nullable=false)
     */
    private $product;

    /**
     * @var string
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string|null
     * @ORM\Column(name="alt_text", type="string", length=255, nullable=true)
     */
    private $altText;

    /**
     * @var int
     * @ORM\Column(name="position", type="integer", options={"default": 0})
     */
    private $position = 0;

    /**
     * @var bool
     * @ORM\Column(name="is_main", type="boolean", options={"default": false})
     */
    private $isMain = false;

    /**
     * @Assert\File(maxSize="6000000", mimeTypes={"image/jpeg", "image/png", "image/webp"})
     */
    private $imageFile;

    public function getId()
    {
        return $this->id;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($product): void
    {
        $this->product = $product;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path): void
    {
        $this->path = $path;
    }

    public function getAltText()
    {
        return $this->altText;
    }

    public function setAltText($altText): void
    {
        $this->altText = $altText;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position): void
    {
        $this->position = $position;
    }

    public function isMain()
    {
        return $this->isMain;
    }

    public function setIsMain($isMain): void
    {
        $this->isMain = $isMain;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile($imageFile): void
    {
        $this->imageFile = $imageFile;
    }
}
