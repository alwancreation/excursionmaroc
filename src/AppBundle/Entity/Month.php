<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Asset
 *
 * @ORM\Table(name="month")
 * @ORM\Entity
 */
class Month
{
    /**
     * @var integer
     *
     * @ORM\Column(name="month_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $monthId;
    /**
     * @var string
     * @ORM\Column(name="month_name", type="string", length=255, nullable=true)
     */
    private $monthName;
    /**
     * @var string
     *
     * @ORM\Column(name="month_code", type="string", length=255, nullable=true)
     */
    private $monthCode;

    /**
     * @return int
     */
    public function getMonthId()
    {
        return $this->monthId;
    }

    /**
     * @param int $monthId
     */
    public function setMonthId($monthId)
    {
        $this->monthId = $monthId;
    }

    /**
     * @return string
     */
    public function getMonthName()
    {
        return $this->monthName;
    }

    /**
     * @param string $monthName
     */
    public function setMonthName($monthName)
    {
        $this->monthName = $monthName;
    }

    /**
     * @return string
     */
    public function getMonthCode()
    {
        return $this->monthCode;
    }

    /**
     * @param string $monthCode
     */
    public function setMonthCode($monthCode)
    {
        $this->monthCode = $monthCode;
    }

    function __toString()
    {
        return $this->getMonthName();
    }


}
