<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Une disponibilité (date + heure) d'une excursion, avec places et prix
 * éventuellement spécifiques à cette date.
 *
 * @ORM\Table(name="excursion_schedule")
 * @ORM\Entity(repositoryClass="App\Repository\ExcursionScheduleRepository")
 */
class ExcursionSchedule
{
    const STATUS_OPEN = 'OPEN';
    const STATUS_FULL = 'FULL';
    const STATUS_CANCELLED = 'CANCELLED';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="schedules")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", onDelete="CASCADE", nullable=false)
     */
    private $product;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string|null
     * @ORM\Column(name="time", type="string", length=20, nullable=true)
     */
    private $time;

    /**
     * @var int
     * @ORM\Column(name="capacity", type="integer")
     */
    private $capacity;

    /**
     * @var int
     * @ORM\Column(name="remaining_capacity", type="integer")
     */
    private $remainingCapacity;

    /**
     * Prix spécifique à cette date, sinon utilise le prix de base du produit.
     *
     * @var float|null
     * @ORM\Column(name="price", type="float", nullable=true)
     */
    private $price;

    /**
     * @var string
     * @ORM\Column(name="status", type="string", length=20, options={"default": "OPEN"})
     */
    private $status = self::STATUS_OPEN;

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

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time): void
    {
        $this->time = $time;
    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function setCapacity($capacity): void
    {
        $this->capacity = $capacity;
    }

    public function getRemainingCapacity()
    {
        return $this->remainingCapacity;
    }

    public function setRemainingCapacity($remainingCapacity): void
    {
        $this->remainingCapacity = $remainingCapacity;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function isFull(): bool
    {
        return $this->status === self::STATUS_FULL || $this->remainingCapacity <= 0;
    }

    public static function getStatuses(): array
    {
        return [self::STATUS_OPEN, self::STATUS_FULL, self::STATUS_CANCELLED];
    }
}
