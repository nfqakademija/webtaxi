<?php

namespace Webtaxi\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class User
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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", nullable=true, length=255)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="location_longitude", type="decimal")
     */
    private $locationLongitude;

    /**
     * @var string
     *
     * @ORM\Column(name="location_latitude", type="decimal")
     */
    private $locationLatitude;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="location_updated_at", type="datetimetz")
     */
    private $locationUpdatedAt;


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
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
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
}
