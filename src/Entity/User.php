<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var string|null
     * @ORM\Column(name="google_id", type="string", length=255, nullable=true)
     */
    private $googleId;

    /**
     * @var string|null
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
     */
    private $facebookId;

    /**
     * @var string
     *
     * @ORM\Column(name="user_first_name", type="string", length=150, nullable=true)
     */
    private $user_first_name;

    /**
     * @var string
     *
     * @ORM\Column(name="user_last_name", type="string", length=150, nullable=true)
     */
    private $user_last_name;

    /**
     * @var string
     *
     * @ORM\Column(name="user_phone", type="string", length=150, nullable=true)
     */
    private $user_phone;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $userType;

    // guide day price
    /**
     * @var string
     *
     * @ORM\Column(name="user_day_price", type="float", nullable=true)
     */
    private $user_day_price;

    // guide half day price
    /**
     * @var string
     *
     * @ORM\Column(name="user_half_day_price", type="float", nullable=true)
     */
    private $user_half_day_price;



    public function getLetterName(): ?string
    {
        if(strlen($this->user_first_name) == 0) return 'U';
        return strtoupper(substr($this->user_first_name, 0, 1));

    }


    /**
     * @return string
     */
    public function getUserType(): string
    {
        return $this->userType;
    }

    /**
     * @param string $userType
     */
    public function setUserType(string $userType): void
    {
        $this->userType = $userType;
    }

    /**
     * @return string
     */
    public function getUserDayPrice(): string
    {
        return $this->user_day_price;
    }

    /**
     * @param string $user_day_price
     */
    public function setUserDayPrice(string $user_day_price): void
    {
        $this->user_day_price = $user_day_price;
    }

    /**
     * @return string
     */
    public function getUserHalfDayPrice(): string
    {
        return $this->user_half_day_price;
    }

    /**
     * @param string $user_half_day_price
     */
    public function setUserHalfDayPrice(string $user_half_day_price): void
    {
        $this->user_half_day_price = $user_half_day_price;
    }




    /**
     * @var string
     *
     * @ORM\Column(name="user_address", type="string", length=150, nullable=true)
     */
    private $user_address;


    /**
     * @var \App\Entity\Asset
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Asset" , cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="asset_id", referencedColumnName="asset_id")
     * })
     */
    private $asset;
    /**
     * @Assert\File(maxSize="6000000000000")
     */
    private $assetFile;

    /**
     * @var \App\Entity\Asset
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Asset" , cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="asset_identity_id", referencedColumnName="asset_id")
     * })
     */
    private $assetIdentity;
    /**
     * @Assert\File(maxSize="6000000000000")
     */
    private $assetIdentityFile;

    /**
     * @var \App\Entity\Asset
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Asset" , cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="asset_driver_license_id", referencedColumnName="asset_id")
     * })
     */
    private $assetDriverLicense;
    /**
     * @Assert\File(maxSize="6000000000000")
     */
    private $assetDriverLicenseFile;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="driver_license_expiration_date", type="datetime", nullable=true)
     */
    private $driverLicenseExpirationDate;

    /**
     * @var \App\Entity\Asset
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Asset" , cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="asset_medical_visit_id", referencedColumnName="asset_id")
     * })
     */
    private $assetMedicalVisit;
    /**
     * @Assert\File(maxSize="6000000000000")
     */
    private $assetMedicalVisitFile;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="medical_visit_expiration_date", type="datetime", nullable=true)
     */
    private $medicalVisitExpirationDate;

    /**
     * @var boolean|null
     *
     * @ORM\Column(name="internal", type="boolean", nullable=true)
     */
    private $internal;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    private $startDate;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param mixed $lastLogin
     */
    public function setLastLogin($lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @return string|null
     */
    public function getGoogleId(): ?string
    {
        return $this->googleId;
    }

    /**
     * @param string|null $googleId
     */
    public function setGoogleId(?string $googleId): void
    {
        $this->googleId = $googleId;
    }

    /**
     * @return string|null
     */
    public function getFacebookId(): ?string
    {
        return $this->facebookId;
    }

    /**
     * @param string|null $facebookId
     */
    public function setFacebookId(?string $facebookId): void
    {
        $this->facebookId = $facebookId;
    }

    /**
     * @return string
     */
    public function getUserFirstName(): ?string
    {
        return $this->user_first_name;
    }

    /**
     * @param string $user_first_name
     */
    public function setUserFirstName(?string $user_first_name): void
    {
        $this->user_first_name = $user_first_name;
    }

    /**
     * @return string
     */
    public function getUserLastName(): ?string
    {
        return $this->user_last_name;
    }

    /**
     * @param string $user_last_name
     */
    public function setUserLastName(?string $user_last_name): void
    {
        $this->user_last_name = $user_last_name;
    }

    /**
     * @return string
     */
    public function getUserPhone(): ?string
    {
        return $this->user_phone;
    }

    /**
     * @param string $user_phone
     */
    public function setUserPhone(?string $user_phone): void
    {
        $this->user_phone = $user_phone;
    }

    /**
     * @return string
     */
    public function getUserAddress(): ?string
    {
        return $this->user_address;
    }

    /**
     * @param string $user_address
     */
    public function setUserAddress(?string $user_address): void
    {
        $this->user_address = $user_address;
    }

    /**
     * @return Asset
     */
    public function getAsset(): ?Asset
    {
        return $this->asset;
    }

    /**
     * @param Asset $asset
     */
    public function setAsset(?Asset $asset): void
    {
        $this->asset = $asset;
    }

    /**
     * @return mixed
     */
    public function getAssetFile()
    {
        return $this->assetFile;
    }

    /**
     * @param mixed $assetFile
     */
    public function setAssetFile($assetFile): void
    {
        $this->assetFile = $assetFile;
    }

    /**
     * @return Asset
     */
    public function getAssetIdentity(): ?Asset
    {
        return $this->assetIdentity;
    }

    /**
     * @param Asset $assetIdentity
     */
    public function setAssetIdentity(?Asset $assetIdentity): void
    {
        $this->assetIdentity = $assetIdentity;
    }

    /**
     * @return mixed
     */
    public function getAssetIdentityFile()
    {
        return $this->assetIdentityFile;
    }

    /**
     * @param mixed $assetIdentityFile
     */
    public function setAssetIdentityFile($assetIdentityFile): void
    {
        $this->assetIdentityFile = $assetIdentityFile;
    }

    /**
     * @return Asset
     */
    public function getAssetDriverLicense(): ?Asset
    {
        return $this->assetDriverLicense;
    }

    /**
     * @param Asset $assetDriverLicense
     */
    public function setAssetDriverLicense(?Asset $assetDriverLicense): void
    {
        $this->assetDriverLicense = $assetDriverLicense;
    }

    /**
     * @return mixed
     */
    public function getAssetDriverLicenseFile()
    {
        return $this->assetDriverLicenseFile;
    }

    /**
     * @param mixed $assetDriverLicenseFile
     */
    public function setAssetDriverLicenseFile($assetDriverLicenseFile): void
    {
        $this->assetDriverLicenseFile = $assetDriverLicenseFile;
    }

    /**
     * @return \DateTime|null
     */
    public function getDriverLicenseExpirationDate(): ?\DateTime
    {
        return $this->driverLicenseExpirationDate;
    }

    /**
     * @param \DateTime|null $driverLicenseExpirationDate
     */
    public function setDriverLicenseExpirationDate(?\DateTime $driverLicenseExpirationDate): void
    {
        $this->driverLicenseExpirationDate = $driverLicenseExpirationDate;
    }

    /**
     * @return Asset
     */
    public function getAssetMedicalVisit(): ?Asset
    {
        return $this->assetMedicalVisit;
    }

    /**
     * @param Asset $assetMedicalVisit
     */
    public function setAssetMedicalVisit(?Asset $assetMedicalVisit): void
    {
        $this->assetMedicalVisit = $assetMedicalVisit;
    }

    /**
     * @return mixed
     */
    public function getAssetMedicalVisitFile()
    {
        return $this->assetMedicalVisitFile;
    }

    /**
     * @param mixed $assetMedicalVisitFile
     */
    public function setAssetMedicalVisitFile($assetMedicalVisitFile): void
    {
        $this->assetMedicalVisitFile = $assetMedicalVisitFile;
    }

    /**
     * @return \DateTime|null
     */
    public function getMedicalVisitExpirationDate(): ?\DateTime
    {
        return $this->medicalVisitExpirationDate;
    }

    /**
     * @param \DateTime|null $medicalVisitExpirationDate
     */
    public function setMedicalVisitExpirationDate(?\DateTime $medicalVisitExpirationDate): void
    {
        $this->medicalVisitExpirationDate = $medicalVisitExpirationDate;
    }

    /**
     * @return bool|null
     */
    public function getInternal(): ?bool
    {
        return $this->internal;
    }

    /**
     * @param bool|null $internal
     */
    public function setInternal(?bool $internal): void
    {
        $this->internal = $internal;
    }

    /**
     * @return \DateTime|null
     */
    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime|null $startDate
     */
    public function setStartDate(?\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getRole()
    {
        return implode(', ', $this->getRoles());
    }

    public function hasRole(string $string)
    {
        return in_array($string, $this->getRoles());
    }

    public function addRole(string $string)
    {
        $this->roles[]=$string;
    }
    public function addRole1(string $string)
    {
        $this->roles[]=$string;
    }


    public function toJsonObject()
    {
        $obj = new \stdClass();
        $obj->id = $this->id;
        $obj->name = $this->__toString();
        $obj->email = $this->getEmail();
        $obj->phone = $this->getUserPhone();
        return $obj;
    }


    // role => url
    public function getRolesArrayKies()
    {
        $roles = array();
        foreach ($this->getRolesArray() as $key => $roleName) {
            $roles[$key] = $key;
        }
        return $roles;
    }
    /**
     * supprimer les roles
     */
    public function removeAllRoles()
    {
        $this->roles = [];
    }

    // role => url
    public function getRolesArray()
    {
        return array(
            'ROLE_ADMIN' => 'ADMIN',
            'ROLE_GUIDE' => 'GUIDE',
            'ROLE_MANAGER' => 'MANAGER',

        );
    }

    public function getMainRole()
    {
        $roles = $this->getRolesArray();
        foreach ($this->getRoles() as $role) {
            if (isset($roles[$role])) {
                return $roles[$role];
            }
        }
        return '';
    }


    public function __toString()
    {
        if($this->user_first_name && $this->user_last_name)
        return $this->user_first_name.' '.$this->user_last_name;
        else
        return $this->email.'';
    }


}
