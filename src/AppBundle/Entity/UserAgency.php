<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Vehicle
 *
 * @ORM\Table(name="user_agency")
 * @ORM\Entity
 */
class UserAgency
{



    /**
     * @var \AppBundle\Entity\Agency
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Agency", inversedBy="users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agency_id", referencedColumnName="id", nullable=false, onDelete="cascade")
     * })
     */
    private $agency;

    /**
     * @var \AppBundle\Entity\User
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="agencies")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="cascade")
     * })
     */
    private $user;


    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255, nullable=true)
     */
    private $role;


    /**
     * UserAgency constructor.
     */
    public function __construct()
    {
        $this->role = 'manager';
    }


    /**
     * @return Agency
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * @param Agency $agency
     */
    public function setAgency($agency)
    {
        $this->agency = $agency;
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
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }



}
