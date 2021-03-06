<?php

namespace Webtaxi\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class User extends BaseUser implements JsonSerializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string
     *
     * @ORM\Column(name="firstName", nullable=true, type="string", length=255)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", nullable=true, type="string", length=255)
     */
    protected $lastName;


    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", nullable=true, length=255)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="location_longitude", nullable=true, type="decimal")
     */
    private $locationLongitude;

    /**
     * @var string
     *
     * @ORM\Column(name="location_latitude", nullable=true, type="decimal")
     */
    private $locationLatitude;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="location_updated_at", nullable=true, type="datetimetz")
     */
    private $locationUpdatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="car_license_plate", nullable=true, type="string", length=20)
     * @Assert\Length(max = "20")
     * @Assert\Type(type="string")
     */
    private $carLicensePlate;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", nullable=true, type="string", length=20)
     * @Assert\Length(max = "20")
     * @Assert\Type(type="string")
     */
    private $mobile;


    public function __construct()
    {
        parent::__construct();
    }

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
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set name
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set surname
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set photo
     *
     * @param string $photo
     * @return User
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set locationLongitude
     *
     * @param string $locationLongitude
     * @return User
     */
    public function setLocationLongitude($locationLongitude)
    {
        $this->locationLongitude = $locationLongitude;

        return $this;
    }

    /**
     * Get locationLongitude
     *
     * @return string 
     */
    public function getLocationLongitude()
    {
        return $this->locationLongitude;
    }

    /**
     * Set locationLatitude
     *
     * @param string $locationLatitude
     * @return User
     */
    public function setLocationLatitude($locationLatitude)
    {
        $this->locationLatitude = $locationLatitude;

        return $this;
    }

    /**
     * Get locationLatitude
     *
     * @return string 
     */
    public function getLocationLatitude()
    {
        return $this->locationLatitude;
    }

    /**
     * Set locationUpdatedAt
     *
     * @param \DateTime $locationUpdatedAt
     * @return User
     */
    public function setLocationUpdatedAt($locationUpdatedAt)
    {
        $this->locationUpdatedAt = $locationUpdatedAt;

        return $this;
    }

    /**
     * Get locationUpdatedAt
     *
     * @return \DateTime 
     */
    public function getLocationUpdatedAt()
    {
        return $this->locationUpdatedAt;
    }

    /**
     * @return string
     */
    public function getCarLicensePlate()
    {
        return $this->carLicensePlate;
    }

    /**
     * @param string $carLicensePlate
     */
    public function setCarLicensePlate($carLicensePlate)
    {
        $this->carLicensePlate = $carLicensePlate;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return array|mixed encoded json (for travel table)
     */
    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName
        ];
    }
}
