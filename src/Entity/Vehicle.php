<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vehicle
 *
 * @ORM\Table(name="vehicle")
 * @ORM\Entity
 */
class Vehicle
{
    /**
     * @var integer
     *
     * @ORM\Column(name="vehicle_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $vehicleId;

    /**
     * @var string
     *
     * @ORM\Column(name="vehicle_name", type="string", length=255, nullable=true)
     */
    private $vehicleName;


    /**
     * @var string
     *
     * @ORM\Column(name="vehicle_short_description", type="text", length=65535, nullable=true)
     */
    private $vehicleShortDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="vehicle_long_description", type="text", length=65535, nullable=true)
     */
    private $vehicleLongDescription;


    /**
     * @var double
     *
     * @ORM\Column(name="vehicle_price", type="float", nullable=true)
     */
    private $vehiclePrice;

    /**
     * @return float
     */
    public function getVehiclePrice()
    {
        return $this->vehiclePrice;
    }

    /**
     * @param float $vehiclePrice
     */
    public function setVehiclePrice($vehiclePrice)
    {
        $this->vehiclePrice = $vehiclePrice;
    }







    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Asset", inversedBy="vehicles", cascade={"persist"})
     * @ORM\JoinTable(name="vehicle_has_asset",
     *   joinColumns={
     *     @ORM\JoinColumn(name="vehicle_id", referencedColumnName="vehicle_id", onDelete="cascade")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="asset_id", referencedColumnName="asset_id", onDelete="cascade")
     *   }
     * )
     */
    private $assets;

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * @param Asset $asset
     * @internal param \Doctrine\Common\Collections\Collection $assets
     */
    public function addAsset(Asset $asset)
    {
        $this->assets->add($asset);
    }

    public function removeAsset(Asset $asset)
    {
        $this->assets->removeElement($asset);
    }
    private $mainAsset;

    /**
     * @return mixed
     */
    public function getMainAsset()
    {
        if($this->assets->count()>0){
            /** @var Asset $asset */
            foreach ($this->assets as $asset){
                if($asset->getAssetIsMain()){
                    return $asset;
                }
            }
            return $this->assets->get(0);
        }
        return null;
    }


    /**
     * Get vehicleId
     *
     * @return integer
     */
    public function getVehicleId()
    {
        return $this->vehicleId;
    }

    /**
     * Set vehicleName
     *
     * @param string $vehicleName
     *
     * @return Vehicle
     */
    public function setVehicleName($vehicleName)
    {
        $this->vehicleName = $vehicleName;

        return $this;
    }

    /**
     * Get vehicleName
     *
     * @return string
     */
    public function getVehicleName()
    {
        return $this->vehicleName;
    }

    /**
     * Set vehicleShortDescription
     *
     * @param string $vehicleShortDescription
     *
     * @return Vehicle
     */
    public function setVehicleShortDescription($vehicleShortDescription)
    {
        $this->vehicleShortDescription = $vehicleShortDescription;

        return $this;
    }

    /**
     * Get vehicleShortDescription
     *
     * @return string
     */
    public function getVehicleShortDescription()
    {
        return $this->vehicleShortDescription;
    }

    /**
     * Set vehicleLongDescription
     *
     * @param string $vehicleLongDescription
     *
     * @return Vehicle
     */
    public function setVehicleLongDescription($vehicleLongDescription)
    {
        $this->vehicleLongDescription = $vehicleLongDescription;

        return $this;
    }

    /**
     * Get vehicleLongDescription
     *
     * @return string
     */
    public function getVehicleLongDescription()
    {
        return $this->vehicleLongDescription;
    }





    function __toString()
    {
        return $this->vehicleName;
    }
}
