<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avis client sur une excursion. Toujours rattaché à une réservation
 * réelle (booking) pour garantir qu'on ne peut noter que ce qu'on a
 * effectivement réservé — un seul avis par réservation.
 *
 * @ORM\Table(name="review", indexes={@ORM\Index(name="idx_review_status", columns={"status"})})
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 */
class Review
{
    public const STATUS_PUBLISHED = 'PUBLISHED';
    public const STATUS_HIDDEN = 'HIDDEN';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MarketplaceBooking")
     * @ORM\JoinColumn(name="booking_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $booking;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="reviews")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", nullable=false, onDelete="CASCADE")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agency")
     * @ORM\JoinColumn(name="agency_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $agency;

    /**
     * @var int
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating;

    /**
     * @var string
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @var string
     * @ORM\Column(name="status", type="string", length=20, options={"default": "PUBLISHED"})
     */
    private $status = self::STATUS_PUBLISHED;

    /**
     * @var string|null
     * @ORM\Column(name="agency_reply", type="text", nullable=true)
     */
    private $agencyReply;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="agency_reply_date", type="datetime", nullable=true)
     */
    private $agencyReplyDate;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_create", type="datetime")
     */
    private $dateCreate;

    public function __construct()
    {
        $this->dateCreate = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getBooking()
    {
        return $this->booking;
    }

    public function setBooking($booking): void
    {
        $this->booking = $booking;
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

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating): void
    {
        $this->rating = $rating;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function getAgencyReply()
    {
        return $this->agencyReply;
    }

    public function setAgencyReply($agencyReply): void
    {
        $this->agencyReply = $agencyReply;
        $this->agencyReplyDate = new \DateTime();
    }

    public function getAgencyReplyDate()
    {
        return $this->agencyReplyDate;
    }

    public function getDateCreate()
    {
        return $this->dateCreate;
    }
}
