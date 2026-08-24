<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Demande de réservation marketplace (client -> excursion d'une agence).
 *
 * Volontairement distincte de l'entité Booking existante (qui sert le
 * fonctionnement interne multi-prestations de l'agence propriétaire de la
 * plateforme) pour ne pas la complexifier ni en modifier le comportement.
 *
 * @ORM\Table(name="marketplace_booking")
 * @ORM\Entity(repositoryClass="App\Repository\MarketplaceBookingRepository")
 */
class MarketplaceBooking
{
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_CONFIRMED = 'CONFIRMED';
    public const STATUS_REJECTED = 'REJECTED';
    public const STATUS_CANCELLED = 'CANCELLED';
    public const STATUS_COMPLETED = 'COMPLETED';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="reference", type="string", length=30, unique=true)
     */
    private $reference;

    /**
     * Voyageur identifié, ou null pour une réservation invité.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", nullable=false, onDelete="CASCADE")
     */
    private $product;

    /**
     * Dénormalisé pour permettre à l'agence de lister ses réservations
     * sans avoir à passer systématiquement par product.agency.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Agency")
     * @ORM\JoinColumn(name="agency_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $agency;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ExcursionSchedule")
     * @ORM\JoinColumn(name="schedule_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $schedule;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var int
     * @ORM\Column(name="adults", type="integer")
     */
    private $adults;

    /**
     * @var int
     * @ORM\Column(name="children", type="integer", options={"default": 0})
     */
    private $children = 0;

    /**
     * @var int
     * @ORM\Column(name="total_participants", type="integer")
     */
    private $totalParticipants;

    /**
     * @var float
     * @ORM\Column(name="unit_price", type="float")
     */
    private $unitPrice;

    /**
     * @var float
     * @ORM\Column(name="total_price", type="float")
     */
    private $totalPrice;

    /**
     * @var string
     * @ORM\Column(name="currency", type="string", length=10, options={"default": "MAD"})
     */
    private $currency = 'MAD';

    /**
     * @var string
     * @ORM\Column(name="customer_name", type="string", length=255)
     */
    private $customerName;

    /**
     * @var string
     * @ORM\Column(name="customer_phone", type="string", length=50)
     */
    private $customerPhone;

    /**
     * @var string
     * @ORM\Column(name="customer_email", type="string", length=255)
     */
    private $customerEmail;

    /**
     * @var string|null
     * @ORM\Column(name="comments", type="text", nullable=true)
     */
    private $comments;

    /**
     * @var string
     * @ORM\Column(name="status", type="string", length=20, options={"default": "PENDING"})
     */
    private $status = self::STATUS_PENDING;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_create", type="datetime")
     */
    private $dateCreate;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_update", type="datetime")
     */
    private $dateUpdate;

    /**
     * Réservés pour une phase ultérieure (commission plateforme / paiement en ligne).
     * Non exploités en V1, gratuite.
     *
     * @var float|null
     * @ORM\Column(name="commission_amount", type="float", nullable=true)
     */
    private $commissionAmount;

    /**
     * @var string|null
     * @ORM\Column(name="payment_status", type="string", length=20, nullable=true)
     */
    private $paymentStatus;

    public function __construct()
    {
        $this->dateCreate = new \DateTime();
        $this->dateUpdate = new \DateTime();
    }

    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_CONFIRMED,
            self::STATUS_REJECTED,
            self::STATUS_CANCELLED,
            self::STATUS_COMPLETED,
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function setReference($reference): void
    {
        $this->reference = $reference;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($product): void
    {
        $this->product = $product;
    }

    public function getAgency()
    {
        return $this->agency;
    }

    public function setAgency($agency): void
    {
        $this->agency = $agency;
    }

    public function getSchedule()
    {
        return $this->schedule;
    }

    public function setSchedule($schedule): void
    {
        $this->schedule = $schedule;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function getAdults()
    {
        return $this->adults;
    }

    public function setAdults($adults): void
    {
        $this->adults = $adults;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren($children): void
    {
        $this->children = $children;
    }

    public function getTotalParticipants()
    {
        return $this->totalParticipants;
    }

    public function setTotalParticipants($totalParticipants): void
    {
        $this->totalParticipants = $totalParticipants;
    }

    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    public function setUnitPrice($unitPrice): void
    {
        $this->unitPrice = $unitPrice;
    }

    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    public function setTotalPrice($totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setCurrency($currency): void
    {
        $this->currency = $currency;
    }

    public function getCustomerName()
    {
        return $this->customerName;
    }

    public function setCustomerName($customerName): void
    {
        $this->customerName = $customerName;
    }

    public function getCustomerPhone()
    {
        return $this->customerPhone;
    }

    public function setCustomerPhone($customerPhone): void
    {
        $this->customerPhone = $customerPhone;
    }

    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    public function setCustomerEmail($customerEmail): void
    {
        $this->customerEmail = $customerEmail;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($comments): void
    {
        $this->comments = $comments;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
        $this->dateUpdate = new \DateTime();
    }

    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    public function getCommissionAmount()
    {
        return $this->commissionAmount;
    }

    public function setCommissionAmount($commissionAmount): void
    {
        $this->commissionAmount = $commissionAmount;
    }

    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus($paymentStatus): void
    {
        $this->paymentStatus = $paymentStatus;
    }
}
