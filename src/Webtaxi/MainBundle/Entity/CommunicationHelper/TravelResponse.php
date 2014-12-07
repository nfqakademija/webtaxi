<?php
/**
 * Created by PhpStorm.
 * User: grt
 * Date: 14-12-07
 * Time: 16:44
 */

namespace Webtaxi\MainBundle\Entity\CommunicationHelper;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Doctrine\ORM\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Webtaxi\MainBundle\Entity\Travel;

class TravelResponse extends Travel  implements JsonSerializable
{
    /**
     * @var boolean - if true, current user is the creator of the travel
     *
     *
     */
    private $isMyTravel;

    /**
     * @var boolean - if true, current user is a creator or a driver of the travel
     *
     *
     */
    private $isMyRelatedTravel;

    /**
     * @param $travel
     */
    function __construct($travel)
    {
        $this->setFromExisting($travel);
    }

    /**
     * Set isMyTravel
     * @param string $isMyTravel
     * @return Travel
     */
    public function setIsMyTravel($isMyTravel)
    {
        $this->isMyTravel = $isMyTravel;

        return $this;
    }

    /**
     * Get isMyTravel
     *
     * @return boolean
     */
    public function getIsMyTravel()
    {
        return $this->isMyTravel;
    }

    /**
     * Set isMyRelatedTravel
     *
     * @param string $isMyRelatedTravel
     * @return Travel
     */
    public function setIsMyRelatedTravel($isMyRelatedTravel)
    {
        $this->isMyRelatedTravel = $isMyRelatedTravel;

        return $this;
    }

    /**
     * Get isMyRelatedTravel
     *
     * @return boolean
     */
    public function getIsMyRelatedTravel()
    {
        return $this->isMyRelatedTravel;
    }
    

    /**
     * @return array|mixed encoded json (for travel table)
     */
    public function jsonSerialize() {
        $timeCallFormated = "";
        if (date('Ymd') == date('Ymd', $this->timeCall->getTimestamp())) {
            //today, show only time:
            $timeCallFormated = $this->timeCall->format("H:i");
        } else {
            $timeCallFormated = $this->timeCall->format("n-d H:i");
        }
        return [
            'id' => $this->id,
            'timeCall' => $timeCallFormated,
            'sourceAddress' => $this->sourceAddress,
            'client' => $this->client,
            'driver' => $this->driver,
            'destinationAddress' => $this->destinationAddress,
            'price' => $this->price,
            'passengerCount' => $this->passengerCount,
            'distance' => $this->distance,
            'profit' => $this->profit,
            'isMyTravel' => $this->isMyTravel,
            'isMyRelatedTravel' => $this->isMyRelatedTravel,
        ];
    }
}
