<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * EntityHistory
 *
 * @ORM\Table(name="entity_history")
 * @ORM\Entity(repositoryClass="App\Repository\EntityHistoryRepository")
 */
class EntityHistory
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id",onDelete="SET NULL")
     */
    private $user;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="datetime", nullable=true)
     */
    private $dateCreate;

    /**
     * @var string
     *
     * @ORM\Column(name="entity_name", type="string", length=255, nullable=true)
     */
    private $entityName;

    /**
     * @var string
     *
     * @ORM\Column(name="entity_id", type="string", length=255, nullable=true)
     */
    private $entityId;

    /**
     * @var string
     *
     * @ORM\Column(name="action_name", type="string", length=255, nullable=true)
     */
    private $actionName;

  /**
     * @var string
     *
     * @ORM\Column(name="action_value", type="text", nullable=true)
     */
    private $actionValue;

    /**
     * @return string
     */
    public function getEntityId(): ?string
    {
        return $this->entityId;
    }

    /**
     * @param string $entityId
     */
    public function setEntityId(?string $entityId): void
    {
        $this->entityId = $entityId;
    }



    /**
     * @return string
     */
    public function getEntityName(): ?string
    {
        return $this->entityName;
    }

    /**
     * @param string $entityName
     */
    public function setEntityName(?string $entityName): void
    {
        $this->entityName = $entityName;
    }

    public function __construct()
    {
        $this->dateCreate = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
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
     * @return string
     */
    public function getActionName(): ?string
    {
        return $this->actionName;
    }

    /**
     * @param string $actionName
     */
    public function setActionName(?string $actionName): void
    {
        $this->actionName = $actionName;
    }

    /**
     * @return string
     */
    public function getActionValue(): ?string
    {
        return $this->actionValue;
    }

    /**
     * @param string $actionValue
     */
    public function setActionValue(?string $actionValue): void
    {
        $this->actionValue = $actionValue;
    }


}
