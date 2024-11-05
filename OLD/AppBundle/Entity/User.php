<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends \FOS\UserBundle\Model\User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


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
     * @ORM\Column(name="user_address", type="string", length=150, nullable=true)
     */
    private $user_address;


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getUserFirstName()
    {
        return $this->user_first_name;
    }

    /**
     * @param string $user_first_name
     */
    public function setUserFirstName($user_first_name)
    {
        $this->user_first_name = $user_first_name;
    }

    /**
     * @return string
     */
    public function getUserLastName()
    {
        return $this->user_last_name;
    }

    /**
     * @param string $user_last_name
     */
    public function setUserLastName($user_last_name)
    {
        $this->user_last_name = $user_last_name;
    }

    /**
     * @return string
     */
    public function getUserPhone()
    {
        return $this->user_phone;
    }

    /**
     * @param string $user_phone
     */
    public function setUserPhone($user_phone)
    {
        $this->user_phone = $user_phone;
    }

    /**
     * @return string
     */
    public function getUserAddress()
    {
        return $this->user_address;
    }

    /**
     * @param string $user_address
     */
    public function setUserAddress($user_address)
    {
        $this->user_address = $user_address;
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
        foreach ($this->getRolesArray() as $key => $role) {
            $this->removeRole($key);
        }
        return $this;
    }

    // role => url
    public function getRolesArray()
    {
        return array(
            'ROLE_ADMIN' => 'ADMIN',
            'ROLE_USER' => 'USER',
            'ROLE_MANAGER' => 'MANAGER',
        );
    }


}