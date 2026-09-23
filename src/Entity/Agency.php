<?php

namespace App\Entity;

use App\Helper\Utils;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Ldap\Adapter\ExtLdap\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Agency
 *
 * @ORM\Table(name="agency")
 * @ORM\Entity(repositoryClass="App\Repository\AgencyRepository")
 */
class Agency
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="long_description", type="text", nullable=true)
     */
    private $longDescription;
    /**
     * @var string
     *
     * @ORM\Column(name="short_description", type="text", nullable=true)
     */
    private $shortDescription;

    /**
     * Raison sociale
     *
     * @var string
     *
     * @ORM\Column(name="legal_name", type="string", length=255, nullable=true)
     */
    private $legalName;

    /**
     * @var string
     *
     * @ORM\Column(name="cover", type="string", length=255, nullable=true)
     */
    private $cover;

    /**
     * @var string
     *
     * @ORM\Column(name="whatsapp", type="string", length=255, nullable=true)
     */
    private $whatsapp;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * Comma-separated list of spoken languages (e.g. "fr,en,ar")
     *
     * @var string
     *
     * @ORM\Column(name="languages_spoken", type="string", length=255, nullable=true)
     */
    private $languagesSpoken;

    /**
     * @var int
     *
     * @ORM\Column(name="years_experience", type="integer", nullable=true)
     */
    private $yearsExperience;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_url", type="string", length=255, nullable=true)
     */
    private $facebookUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="instagram_url", type="string", length=255, nullable=true)
     */
    private $instagramUrl;

    /**
     * Badge de confiance attribué par l'admin (distinct du statut actif/inactif).
     *
     * @var bool
     *
     * @ORM\Column(name="verified", type="boolean", nullable=true, options={"default": false})
     */
    private $verified;




    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;


    /**
     * @var boolean
     *
     * @ORM\Column(name="valid", type="boolean", nullable=true)
     */
    private $valid;



    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="datetime", nullable=true)
     */
    private $dateCreate;



    /**
     * @var \App\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="utilisateur", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \App\Entity\City
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\City")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     * })
     */
    private $city;

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $asset_file;

    /**
     * @return mixed
     */
    public function getAssetFile()
    {
        return $this->asset_file;
    }

    /**
     * @param mixed $asset_file
     */
    public function setAssetFile($asset_file)
    {
        $this->asset_file = $asset_file;
    }

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $cover_file;

    /**
     * @return mixed
     */
    public function getCoverFile()
    {
        return $this->cover_file;
    }

    /**
     * @param mixed $cover_file
     */
    public function setCoverFile($cover_file)
    {
        $this->cover_file = $cover_file;
    }






    /**
     * @var string
     *
     * @ORM\Column(name="rc", type="string", length=255, nullable=true)
     */
    private $rc;


    /**
     * @var string
     *
     * @ORM\Column(name="ice", type="string", length=255, nullable=true)
     */
    private $ice;

    /**
     * @var string
     *
     * @ORM\Column(name="site", type="string", length=255, nullable=true)
     */
    private $site;

    /**
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param string $site
     */
    public function setSite($site)
    {
        $this->site = $site;
    }

    /**
     * @return string
     */
    public function getLegalName()
    {
        return $this->legalName;
    }

    /**
     * @param string $legalName
     */
    public function setLegalName($legalName)
    {
        $this->legalName = $legalName;
    }

    /**
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param string $cover
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
    }

    /**
     * @return string
     */
    public function getWhatsapp()
    {
        return $this->whatsapp;
    }

    /**
     * @param string $whatsapp
     */
    public function setWhatsapp($whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getLanguagesSpoken()
    {
        return $this->languagesSpoken;
    }

    /**
     * @param string $languagesSpoken
     */
    public function setLanguagesSpoken($languagesSpoken)
    {
        $this->languagesSpoken = $languagesSpoken;
    }

    /**
     * @return int
     */
    public function getYearsExperience()
    {
        return $this->yearsExperience;
    }

    /**
     * @param int $yearsExperience
     */
    public function setYearsExperience($yearsExperience)
    {
        $this->yearsExperience = $yearsExperience;
    }

    /**
     * @return string
     */
    public function getFacebookUrl()
    {
        return $this->facebookUrl;
    }

    /**
     * @param string $facebookUrl
     */
    public function setFacebookUrl($facebookUrl)
    {
        $this->facebookUrl = $facebookUrl;
    }

    /**
     * @return string
     */
    public function getInstagramUrl()
    {
        return $this->instagramUrl;
    }

    /**
     * @param string $instagramUrl
     */
    public function setInstagramUrl($instagramUrl)
    {
        $this->instagramUrl = $instagramUrl;
    }

    /**
     * @return bool
     */
    public function isVerified()
    {
        return $this->verified;
    }

    /**
     * @param bool $verified
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;
    }

    public $user_first_name;
    public $user_last_name;
    public $user_email;
    public $user_password;
    public $user_password_confirm;



    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="agency")
     */
    private $products;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\UserAgency", mappedBy="agency")
     */
    private $users;

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function addUser(User $user){
        $this->users->add($user);
        return $this;
    }

    public function removeUser(User $user){
        $this->users->removeElement($user);
        return $this;
    }




    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateCreate = new \DateTime();
        $this->valid = true;
        $this->verified = false;
        $this->products = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * @param string $longDescription
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
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
     * @return boolean
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * @param boolean $valid
     */
    public function setValid($valid)
    {
        $this->valid = $valid;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * @param \DateTime $dateCreate
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;
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
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param City $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getRc()
    {
        return $this->rc;
    }

    /**
     * @param string $rc
     */
    public function setRc($rc)
    {
        $this->rc = $rc;
    }

    /**
     * @return string
     */
    public function getIce()
    {
        return $this->ice;
    }

    /**
     * @param string $ice
     */
    public function setIce($ice)
    {
        $this->ice = $ice;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }



    function __toString()
    {
        return $this->name;
    }

}
