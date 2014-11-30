<?php

namespace Webtaxi\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Travel
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Travel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time_call", type="datetimetz")
     */
    private $timeCall;

    /**
     * @var string
     *
     * @ORM\Column(name="source_longitude", type="decimal", precision=11, scale=8)
     * @Assert\NotBlank()
     */
    private $sourceLongitude;

    /**
     * @var string
     *
     * @ORM\Column(name="source_latitude", type="decimal", precision=10, scale=8)
     * @Assert\NotBlank()
     */
    private $sourceLatitude;

    /**
     * @var string
     *
     * @ORM\Column(name="destination_longitude", type="decimal", precision=11, scale=8)
     * @Assert\NotBlank()
     */
    private $destinationLongitude;

    /**
     * @var string
     *
     * @ORM\Column(name="destination_latitude", type="decimal", precision=10, scale=8)
     * @Assert\NotBlank()
     */
    private $destinationLatitude;

    /**
     * @var string
     *
     * @ORM\Column(name="source_address", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $sourceAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="destination_address", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $destinationAddress;

    /**
     * @var integer
     *
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="users")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $clientId;

    /**
     * @var integer
     *
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="user")
     * @ORM\JoinColumn(name="driver_id", nullable=true, referencedColumnName="id")
     */
    private $driverId;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=4, scale=2)
     * @Assert\NotBlank
     * @Assert\Range(
     *      min = 1,
     *      max = 1000,
     *      minMessage = "Kaina negali būti mažesnė nei 1 litas",
     *      maxMessage = "Kaina negali būti didesnė nei 1000 litų"
     * )
     */
    private $price;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_closed", type="boolean")
     */
    private $isClosed;

    /**
     * @var integer
     *
     * @ORM\Column(name="passenger_count", type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 1,
     *      max = 10,
     *      minMessage = "Keleivių skaičius negali būti mažesnis nei 1",
     *      maxMessage = "Keleivių negali būti daugiau nei 10"
     * )
     */
    private $passengerCount;

    /**
     * @var string
     *
     * @ORM\Column(name="distance", type="decimal", precision=5, scale=1)
     * @Assert\NotBlank()
     */
    private $distance;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set timeCall
     *
     * @param \DateTime $timeCall
     * @return Travel
     */
    public function setTimeCall($timeCall)
    {
        $this->timeCall = $timeCall;

        return $this;
    }

    /**
     * Get timeCall
     *
     * @return \DateTime 
     */
    public function getTimeCall()
    {
        return $this->timeCall;
    }

    /**
     * Set sourceLongitude
     *
     * @param string $sourceLongitude
     * @return Travel
     */
    public function setSourceLongitude($sourceLongitude)
    {
        $this->sourceLongitude = $sourceLongitude;

        return $this;
    }

    /**
     * Get sourceLongitude
     *
     * @return string 
     */
    public function getSourceLongitude()
    {
        return $this->sourceLongitude;
    }

    /**
     * Set sourceLatitude
     *
     * @param string $sourceLatitude
     * @return Travel
     */
    public function setSourceLatitude($sourceLatitude)
    {
        $this->sourceLatitude = $sourceLatitude;

        return $this;
    }

    /**
     * Get sourceLatitude
     *
     * @return string 
     */
    public function getSourceLatitude()
    {
        return $this->sourceLatitude;
    }

    /**
     * Set destinationLongitude
     *
     * @param string $destinationLongitude
     * @return Travel
     */
    public function setDestinationLongitude($destinationLongitude)
    {
        $this->destinationLongitude = $destinationLongitude;

        return $this;
    }

    /**
     * Get destinationLongitude
     *
     * @return string 
     */
    public function getDestinationLongitude()
    {
        return $this->destinationLongitude;
    }

    /**
     * Set destinationLatitude
     *
     * @param string $destinationLatitude
     * @return Travel
     */
    public function setDestinationLatitude($destinationLatitude)
    {
        $this->destinationLatitude = $destinationLatitude;

        return $this;
    }

    /**
     * Get destinationLatitude
     *
     * @return string 
     */
    public function getDestinationLatitude()
    {
        return $this->destinationLatitude;
    }

    /**
     * Set sourceAddress
     *
     * @param string $sourceAddress
     * @return Travel
     */
    public function setSourceAddress($sourceAddress)
    {
        $this->sourceAddress = $sourceAddress;

        return $this;
    }

    /**
     * Get sourceAddress
     *
     * @return string 
     */
    public function getSourceAddress()
    {
        return $this->sourceAddress;
    }

    /**
     * Set destinationAddress
     *
     * @param string $destinationAddress
     * @return Travel
     */
    public function setDestinationAddress($destinationAddress)
    {
        $this->destinationAddress = $destinationAddress;

        return $this;
    }

    /**
     * Get destinationAddress
     *
     * @return string 
     */
    public function getDestinationAddress()
    {
        return $this->destinationAddress;
    }

    /**
     * Set clientId
     *
     * @param integer $clientId
     * @return Travel
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * Get clientId
     *
     * @return integer 
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Set driverId
     *
     * @param integer $driverId
     * @return Travel
     */
    public function setDriverId($driverId)
    {
        $this->driverId = $driverId;

        return $this;
    }

    /**
     * Get driverId
     *
     * @return integer 
     */
    public function getDriverId()
    {
        return $this->driverId;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Travel
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set isClosed
     *
     * @param boolean $isClosed
     * @return Travel
     */
    public function setIsClosed($isClosed)
    {
        $this->isClosed = $isClosed;

        return $this;
    }

    /**
     * Get isClosed
     *
     * @return boolean 
     */
    public function getIsClosed()
    {
        return $this->isClosed;
    }

    /**
     * Set passengerCount
     *
     * @param integer $passengerCount
     * @return Travel
     */
    public function setPassengerCount($passengerCount)
    {
        $this->passengerCount = $passengerCount;

        return $this;
    }

    /**
     * Get passengerCount
     *
     * @return integer 
     */
    public function getPassengerCount()
    {
        return $this->passengerCount;
    }

    /**
     * Set distance
     *
     * @param string $distance
     * @return Travel
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return string 
     */
    public function getDistance()
    {
        return $this->distance;
    }
}
