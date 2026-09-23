<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Une étape du programme détaillé d'une excursion (ordre, heure, titre, description, durée, lieu).
 *
 * @ORM\Table(name="excursion_itinerary")
 * @ORM\Entity(repositoryClass="App\Repository\ExcursionItineraryRepository")
 */
class ExcursionItinerary
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="itinerarySteps")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", onDelete="CASCADE", nullable=false)
     */
    private $product;

    /**
     * @var int
     * @ORM\Column(name="position", type="integer", options={"default": 0})
     */
    private $position = 0;

    /**
     * @var string|null
     * @ORM\Column(name="time", type="string", length=20, nullable=true)
     */
    private $time;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string|null
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(name="duration", type="string", length=100, nullable=true)
     */
    private $duration;

    /**
     * @var string|null
     * @ORM\Column(name="location", type="string", length=255, nullable=true)
     */
    private $location;

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

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position): void
    {
        $this->position = $position;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time): void
    {
        $this->time = $time;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration): void
    {
        $this->duration = $duration;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location): void
    {
        $this->location = $location;
    }
}
