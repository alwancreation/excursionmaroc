<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="booking_product")
 */
class BookingProduct
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

    // date start
    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateStart;

    // date end
    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateEnd;

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

    // number of people
    /**
     * @var int|null
     * @ORM\Column(type="integer")
     */
    private $pax;

    /**
     * @var int|null
     * @ORM\Column(type="integer")
     */
    private $numberOfAdults;

    /**
     * @var int|null
     * @ORM\Column(type="integer")
     */
    private $numberOfChildren;


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


    // total price
    /**
     * @var float|null
     * @ORM\Column(type="float")
     */
    private $totalPrice;

    // booking
    /**
     * @ORM\ManyToOne(targetEntity="Booking")
     * @ORM\JoinColumn(name="booking_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $booking;

    /**
     * @var string|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $hourStart;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $flightNumber;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $airport;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $flightCompany;

    /**
     * @return string|null
     */
    public function getHourStart()
    {
        return $this->hourStart;
    }

    /**
     * @param string|null $hourStart
     */
    public function setHourStart($hourStart): void
    {
        $this->hourStart = $hourStart;
    }

    /**
     * @return string|null
     */
    public function getFlightNumber(): ?string
    {
        return $this->flightNumber;
    }

    /**
     * @param string|null $flightNumber
     */
    public function setFlightNumber(?string $flightNumber): void
    {
        $this->flightNumber = $flightNumber;
    }

    /**
     * @return string|null
     */
    public function getAirport(): ?string
    {
        return $this->airport;
    }

    /**
     * @param string|null $airport
     */
    public function setAirport(?string $airport): void
    {
        $this->airport = $airport;
    }

    /**
     * @return string|null
     */
    public function getFlightCompany(): ?string
    {
        return $this->flightCompany;
    }

    /**
     * @param string|null $flightCompany
     */
    public function setFlightCompany(?string $flightCompany): void
    {
        $this->flightCompany = $flightCompany;
    }




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
     * @return int|null
     */
    public function getPax(): ?int
    {
        return $this->pax;
    }

    /**
     * @param int|null $pax
     */
    public function setPax(?int $pax): void
    {
        $this->pax = $pax;
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
     * @return \DateTime|null
     */
    public function getDateStart(): ?\DateTime
    {
        return $this->dateStart;
    }

    /**
     * @param \DateTime|null $dateStart
     */
    public function setDateStart(?\DateTime $dateStart): void
    {
        $this->dateStart = $dateStart;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateEnd(): ?\DateTime
    {
        return $this->dateEnd;
    }

    /**
     * @param \DateTime|null $dateEnd
     */
    public function setDateEnd(?\DateTime $dateEnd): void
    {
        $this->dateEnd = $dateEnd;
    }

    /**
     * @return Product
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
    public function getPricePerPerson(): ?float
    {
        return $this->pricePerPerson;
    }

    /**
     * @param float|null $pricePerPerson
     */
    public function setPricePerPerson(?float $pricePerPerson): void
    {
        $this->pricePerPerson = $pricePerPerson;
    }

    /**
     * @return float|null
     */
    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    /**
     * @param float|null $totalPrice
     */
    public function setTotalPrice(?float $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @return mixed
     */
    public function getBooking()
    {
        return $this->booking;
    }

    /**
     * @param mixed $booking
     */
    public function setBooking($booking): void
    {
        $this->booking = $booking;
    }

    public function __toString()
    {
        return $this->getProductName().'';
    }

    public function getFirstDate()
    {
        return $this->getDateStart()->format('d-m-Y');
    }

    public function getLetterName(): ?string
    {
        return $this->getProduct()->getLetterName();

    }

    /**
     * @return int|null
     */
    public function getNumberOfAdults(): ?int
    {
        return $this->numberOfAdults;
    }

    /**
     * @param int|null $numberOfAdults
     */
    public function setNumberOfAdults(?int $numberOfAdults): void
    {
        $this->numberOfAdults = $numberOfAdults;
    }

    /**
     * @return int|null
     */
    public function getNumberOfChildren(): ?int
    {
        return $this->numberOfChildren;
    }

    /**
     * @param int|null $numberOfChildren
     */
    public function setNumberOfChildren(?int $numberOfChildren): void
    {
        $this->numberOfChildren = $numberOfChildren;
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



}
