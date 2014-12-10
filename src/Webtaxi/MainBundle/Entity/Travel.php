<?php

namespace Webtaxi\MainBundle\Entity;

use DateInterval;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Doctrine\ORM\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Webtaxi\MainBundle\WebtaxiMainBundle;

/**
 * Travel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Webtaxi\MainBundle\Entity\TravelRepository")
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
    protected  $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time_call", type="datetime")
     */
    protected $timeCall;

    /**
     * @var string
     *
     * @ORM\Column(name="source_longitude", type="decimal", precision=11, scale=8)
     * @Assert\NotBlank()
     */
    protected $sourceLongitude;

    /**
     * @var string
     *
     * @ORM\Column(name="source_latitude", type="decimal", precision=10, scale=8)
     * @Assert\NotBlank()
     */
    protected $sourceLatitude;

    /**
     * @var string
     *
     * @ORM\Column(name="destination_longitude", type="decimal", precision=11, scale=8)
     * @Assert\NotBlank()
     */
    protected $destinationLongitude;

    /**
     * @var string
     *
     * @ORM\Column(name="destination_latitude", type="decimal", precision=10, scale=8)
     * @Assert\NotBlank()
     */
    protected $destinationLatitude;

    /**
     * @var string
     *
     * @ORM\Column(name="source_address", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $sourceAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="destination_address", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $destinationAddress;

    /**
     * @var User
     *
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="users")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    protected $client;

    /**
     * @var integer
     *
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="user")
     * @ORM\JoinColumn(name="driver_id", nullable=true, referencedColumnName="id")
     */
    protected $driver;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=4, scale=2)
     * @Assert\Type(type="double", message="Įveskite kainą skaičiais")
     * @Assert\NotBlank(message="Įveskite kainą skaičiais")
     * @Assert\Range(
     *      min = 1,
     *      max = 1000,
     *      minMessage = "Kaina negali būti mažesnė nei 1 litas",
     *      maxMessage = "Kaina negali būti didesnė nei 1000 litų"
     * )
     */
    protected $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="passenger_count", type="integer")
     * @Assert\Type(type="integer", message="Įveskite keleivių skaičių skaičiais")
     * @Assert\NotBlank(message="Įveskite keleivių skaičių")
     * @Assert\Range(
     *      min = 1,
     *      max = 10,
     *      minMessage = "Keleivių skaičius negali būti mažesnis nei 1",
     *      maxMessage = "Keleivių negali būti daugiau nei 10"
     * )
     */
    protected $passengerCount;

    /**
     * @var string
     *
     * @ORM\Column(name="distance", type="decimal", precision=5, scale=1)
     * @Assert\NotBlank(message = "Nurodykite teisingus išvykimo ir atvykimo taškus")
     * @Assert\Type(type="double", message="Šis atstumas turi būti apskaičiuotas automatiškai")
     * @Assert\Range(
     *      min = 1,
     *      max = 500,
     *      minMessage = "Negalima skelbti kelionių, kurių atstumas mažesnis nei 1km",
     *      maxMessage = "Negalima skelbti kelionių, kurių atstumas didesnis nei 500km"
     * )
     */
    protected $distance;

    /**
     * @var string
     *
     * @ORM\Column(name="profit", type="decimal", precision=4, scale=2)
     */
    protected $profit;


    /**
     * @var integer
     *
     * @ORM\Column(name="review_client_rating", nullable=true, type="integer")
     */
    protected $reviewClientRating;


    /**
     * @var string
     *
     * @ORM\Column(name="review_client_comment", nullable=true, type="string", length=255)
     */
    protected $reviewClientComment;


    /**
     * @var integer
     *
     * @ORM\Column(name="review_driver_rating", nullable=true, type="integer")
     */
    protected $reviewDriverRating;


    /**
     * @var string
     *
     * @ORM\Column(name="review_driver_comment", nullable=true, type="string", length=255)
     */
    protected $reviewDriverComment;


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
     * Set client
     *
     * @param user $client
     * @return Travel
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return User
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set driverId
     *
     * @param User $driver
     * @return Travel
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Get User $driver
     *
     * @return User
     */
    public function getDriver()
    {
        return $this->driver;
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

    /**
     * Set profit
     *
     * @param string $distance
     * @return Travel
     */
    public function setProfit($profit)
    {
        $this->profit = $profit;

        return $this;
    }

    /**
     * Get profit
     *
     * @return string
     */
    public function getProfit()
    {
        return $this->profit;
    }

    /**
     * @return string
     */
    public function getReviewClientComment()
    {
        return $this->reviewClientComment;
    }

    /**
     * @param string $reviewClientComment
     */
    public function setReviewClientComment($reviewClientComment)
    {
        $this->reviewClientComment = $reviewClientComment;
    }

    /**
     * @return int
     */
    public function getReviewClientRating()
    {
        return $this->reviewClientRating;
    }

    /**
     * @param int $reviewClientRating
     */
    public function setReviewClientRating($reviewClientRating)
    {
        $this->reviewClientRating = $reviewClientRating;
    }

    /**
     * @return string
     */
    public function getReviewDriverComment()
    {
        return $this->reviewDriverComment;
    }

    /**
     * @param string $reviewDriverComment
     */
    public function setReviewDriverComment($reviewDriverComment)
    {
        $this->reviewDriverComment = $reviewDriverComment;
    }

    /**
     * @return int
     */
    public function getReviewDriverRating()
    {
        return $this->reviewDriverRating;
    }

    /**
     * @param int $reviewDriverRating
     */
    public function setReviewDriverRating($reviewDriverRating)
    {
        $this->reviewDriverRating = $reviewDriverRating;
    }

    /**
     * @param Travel $travel
     * @return void
     */
    public function setFromExisting($travel) {
        $this->id = $travel->getId();
        $this->profit = $travel->getProfit();
        $this->client = $travel->getClient();
        $this->destinationAddress = $travel->getDestinationAddress();
        $this->destinationLatitude = $travel->getDestinationLatitude();
        $this->destinationLongitude = $travel->getDestinationLongitude();
        $this->distance = $travel->getDistance();
        $this->driver = $travel->getDriver();
        $this->passengerCount = $travel->getPassengerCount();
        $this->price = $travel->getPrice();
        $this->sourceAddress = $travel->getSourceAddress();
        $this->sourceLatitude = $travel->getSourceLatitude();
        $this->sourceLongitude = $travel->getSourceLongitude();
        $this->timeCall = $travel->getTimeCall();
        $this->reviewClientRating = $travel->getReviewClientRating();
        $this->reviewClientComment = $travel->getReviewClientComment();
        $this->reviewDriverRating = $travel->getReviewDriverRating();
        $this->reviewDriverComment = $travel->getReviewDriverComment();
    }

    /**
     * is this travel expired or not. If it is expired, it can not be accepted or removed.
     * @return bool
     */
    public function isTravelExpired() {
        $dateNowBeforeTravelExpireTime = new DateTime();
        $dateNowBeforeTravelExpireTime->sub(new DateInterval('PT' . WebtaxiMainBundle::TRAVEL_EXPIRE_TIME . 'M'));
        if ($this->getTimeCall() < $dateNowBeforeTravelExpireTime) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determines is user is a creator of this travel
     * @param $user
     * @return bool
     */
    public function isUserClient($user) {
        if ($this->client == $user) {
            return true;
        }
        return false;
    }

    /**
     * Determines is user a driver of this travel
     * @param $user
     * @return bool
     */
    public function isUserDriver($user) {
        if ($this->driver == $user) {
            return true;
        }
        return false;
    }

    /**
     * Determines has this travel a client review
     * @return bool
     */
    public function isClientReviewGiven() {
        //we dont care about comment because we know its not our responsibility: both comment and rating are mandatory
        if ($this->reviewClientRating != null && $this->reviewClientRating > 0) {
            return true;
        }
        return false;
    }

    /**
     * Determines has this travel a driver review
     * @return bool
     */
    public function isDriverReviewGiven() {
        //we dont care about comment because we know its not our responsibility: both comment and rating are mandatory
        if ($this->reviewDriverRating != null && $this->reviewDriverRating > 0) {
            return true;
        }
        return false;
    }

}
