<?php

namespace Webtaxi\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserChangeEntry
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Webtaxi\MainBundle\Model\UserChangeEntryRepository")
 */
class UserChangeEntry
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
     * @var integer
     *
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="user")
     * @ORM\JoinColumn(name="user_id", nullable=false, referencedColumnName="id")
     */
    protected $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="carLicensePlate", type="string", length=20)
     */
    private $carLicensePlate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateChange", type="datetime")
     */
    private $dateChange;


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
     * Set firstName
     *
     * @param string $firstName
     * @return UserChangeEntry
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return UserChangeEntry
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set carLicensePlate
     *
     * @param string $carLicensePlate
     * @return UserChangeEntry
     */
    public function setCarLicensePlate($carLicensePlate)
    {
        $this->carLicensePlate = $carLicensePlate;

        return $this;
    }

    /**
     * Get carLicensePlate
     *
     * @return string 
     */
    public function getCarLicensePlate()
    {
        return $this->carLicensePlate;
    }

    /**
     * Set dateChange
     *
     * @param \DateTime $dateChange
     * @return UserChangeEntry
     */
    public function setDateChange($dateChange)
    {
        $this->dateChange = $dateChange;

        return $this;
    }

    /**
     * Get dateChange
     *
     * @return \DateTime 
     */
    public function getDateChange()
    {
        return $this->dateChange;
    }
}
