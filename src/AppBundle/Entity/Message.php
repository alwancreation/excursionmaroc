<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="message")
 * @ORM\Entity
 */
class Message
{
    /**
     * @var integer
     *
     * @ORM\Column(name="message_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $messageId;


    /**
     * @var \AppBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="category_id")
     * })
     */
    private $category;

    /**
     * @var \AppBundle\Entity\Vehicle
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vehicle_id", referencedColumnName="vehicle_id")
     * })
     */
    private $vehicle;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_persons", type="integer", nullable=true)
     */
    private $number_persons;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_of_children", type="integer", nullable=true)
     */
    private $numberOfChildren;

    public $dateStartInput;
    public $dateEndInput;

    /**
     * @return int
     */
    public function getNumberOfChildren()
    {
        return $this->numberOfChildren;
    }

    /**
     * @param int $numberOfChildren
     */
    public function setNumberOfChildren($numberOfChildren)
    {
        $this->numberOfChildren = $numberOfChildren;
    }


    /**
     * @var \AppBundle\Entity\Theme
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Theme")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="theme_id", referencedColumnName="theme_id")
     * })
     */
    private $theme;

    /**
     * @var \AppBundle\Entity\Destination
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Destination")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destination_start_id", referencedColumnName="destination_id")
     * })
     */
    private $destinationFrom;

    /**
     * @var \AppBundle\Entity\Destination
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Destination")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destination_end_id", referencedColumnName="destination_id")
     * })
     */
    private $destinationTo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_start", type="datetime", nullable=true)
     */
    private $date_start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_end", type="datetime", nullable=true)
     */
    private $date_end;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $first_name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $last_name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="message_content", type="text", nullable=true)
     */
    private $message_content;

    public function __construct()
    {
        $this->date_create = new \DateTime();
    }


    /**
     * @return Vehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * @param Vehicle $vehicle
     */
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;
    }



    /**
     * @return int
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @param int $messageId
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
    }


    /**
     * @var \AppBundle\Entity\Product
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="product_id")
     * })
     */
    private $product;
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
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return int
     */
    public function getNumberPersons()
    {
        return $this->number_persons;
    }

    /**
     * @param int $number_persons
     */
    public function setNumberPersons($number_persons)
    {
        $this->number_persons = $number_persons;
    }

    /**
     * @return Theme
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param Theme $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * @return Destination
     */
    public function getDestinationFrom()
    {
        return $this->destinationFrom;
    }

    /**
     * @param Destination $destinationFrom
     */
    public function setDestinationFrom($destinationFrom)
    {
        $this->destinationFrom = $destinationFrom;
    }

    /**
     * @return Destination
     */
    public function getDestinationTo()
    {
        return $this->destinationTo;
    }

    /**
     * @param Destination $destinationTo
     */
    public function setDestinationTo($destinationTo)
    {
        $this->destinationTo = $destinationTo;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->date_start;
    }

    /**
     * @param \DateTime $date_start
     */
    public function setDateStart($date_start)
    {
        $this->date_start = $date_start;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->date_end;
    }

    /**
     * @param \DateTime $date_end
     */
    public function setDateEnd($date_end)
    {
        $this->date_end = $date_end;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getMessageContent()
    {
        return $this->message_content;
    }

    /**
     * @param string $message_content
     */
    public function setMessageContent($message_content)
    {
        $this->message_content = $message_content;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="datetime", nullable=true)
     */
    private $date_create;

    /**
     * @return \DateTime
     */
    public function getDateCreate()
    {
        return $this->date_create;
    }

    /**
     * @param \DateTime $date_create
     */
    public function setDateCreate($date_create)
    {
        $this->date_create = $date_create;
    }




}
