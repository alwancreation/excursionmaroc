<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 * @ORM\Table(name="booking")
 */
class Booking
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

    // date start
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateStart;

    // date end
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateEnd;

    // client
    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $client;
    // client
    /**
     * @ORM\ManyToOne(targetEntity="Package")
     * @ORM\JoinColumn(name="package_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $package;

    /**
     * @return Package||null
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @param mixed $package
     */
    public function setPackage($package): void
    {
        $this->package = $package;
    }



    // client Name
    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $clientName;


    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $numberOfAdults;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $numberOfChildren;




    // pax
    static $booking_status = [
        0 => 'Pending',
        1 => 'Validated',
        2 => 'Cancelled',
    ];

    public function getStatusString()
    {
        return (isset(self::$booking_status[intval($this->status)])) ? self::$booking_status[intval($this->status)] : 'Unknown';
    }

    public function getStatusClass()
    {
        if($this->status == 0)
        {
            return 'badge-light';
        }
        if($this->status == 1)
        {
            return 'badge-light-success';
        }
        if($this->status == 2)
        {
            return 'badge-light-danger';
        }
        return 'badge-light';
    }



    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $pax;
    /**
     * @var string | null
     * @ORM\Column(type="integer",nullable=true, options={"default": 0})
     */
    private $status;


    // products
    /**
     * @ORM\OneToMany(targetEntity="BookingProduct", mappedBy="booking")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="BookingGuide", mappedBy="booking")
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



    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return int
     */
    public function getNumberOfAdults(): ?int
    {
        return $this->numberOfAdults;
    }

    /**
     * @param int $numberOfAdults
     */
    public function setNumberOfAdults(?int $numberOfAdults): void
    {
        $this->numberOfAdults = $numberOfAdults;
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
        return $this->getPoductsType('accommodation');
    }
    public function getTransferProducts()
    {
        return $this->getPoductsType('transfer');
    }
    public function getActivitiesProducts()
    {
        return $this->getPoductsType('activity');
    }
    public function getOtherProducts()
    {
        return $this->getPoductsType('other');
    }
    public function getTransportProducts()
    {
        return $this->getPoductsType('transport');
    }
//    tour
//    restaurant

    public function getTourProducts()
    {
        return $this->getPoductsType('tour');
    }

    public function getRestaurantProducts()
    {
        return $this->getPoductsType('restaurant');
    }

    public function getMonumentProducts()
    {
        return $this->getPoductsType('monument');
    }




    public function getPoductsType($type)
    {
        return $this->products->filter(function($product) use ($type){
            return $product->getProduct()->getType() == $type;
        });
    }




    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }




    public function __construct()
    {
        $this->dateCreate = new \DateTime();
        $this->numberOfAdults = 2;
        $this->numberOfChildren = 0;
        $this->pax = 2;
        $this->dateStart = new \DateTime();
        $this->dateEnd = new \DateTime('+1 day');
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->guides = new \Doctrine\Common\Collections\ArrayCollection();

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
     * @return \DateTime
     */
    public function getDateCreate(): ?\DateTime
    {
        return $this->dateCreate;
    }

    /**
     * @param \DateTime $dateCreate
     */
    public function setDateCreate(?\DateTime $dateCreate): void
    {
        $this->dateCreate = $dateCreate;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart(): ?\DateTime
    {
        return $this->dateStart;
    }

    /**
     * @param \DateTime $dateStart
     */
    public function setDateStart(?\DateTime $dateStart): void
    {
        $this->dateStart = $dateStart;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd(): ?\DateTime
    {
        return $this->dateEnd;
    }

    /**
     * @param \DateTime $dateEnd
     */
    public function setDateEnd(?\DateTime $dateEnd): void
    {
        $this->dateEnd = $dateEnd;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client): void
    {
        $this->client = $client;
    }

    /**
     * @return string|null
     */
    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    /**
     * @param string|null $clientName
     */
    public function setClientName(?string $clientName): void
    {
        $this->clientName = $clientName;
    }


    /**
     * @return int
     */
    public function getNumberOfRooms(): ?int
    {
        return $this->numberOfRooms;
    }

    /**
     * @param int $numberOfRooms
     */
    public function setNumberOfRooms(?int $numberOfRooms): void
    {
        $this->numberOfRooms = $numberOfRooms;
    }

    /**
     * @return int
     */
    public function getNumberOfChildren(): ?int
    {
        return $this->numberOfChildren;
    }

    /**
     * @param int $numberOfChildren
     */
    public function setNumberOfChildren(?int $numberOfChildren): void
    {
        $this->numberOfChildren = $numberOfChildren;
    }

    /**
     * @return int
     */
    public function getPax(): ?int
    {
        return $this->pax;
    }

    /**
     * @param int $pax
     */
    public function setPax(?int $pax): void
    {
        $this->pax = $pax;
    }


    public function getTotalPrice()
    {
        $total = 0;
        /** @var BookingProduct $product */
        foreach ($this->products as $product)
        {
            $total += $product->getTotalPrice();
        }
        return $total;
    }


    public function getTotalPriceTtc(){
        return $this->getTotalPrice() + $this->getTotalTva();
    }

    public function getTotalTva()
    {
        return $this->getTotalPrice() * 0.2;
    }

    public function addProduct(BookingProduct $bookingProduct)
    {
        $this->products->add($bookingProduct);
    }
    // add guide
    public function addGuide($guide)
    {
        $this->guides->add($guide);
    }

}
