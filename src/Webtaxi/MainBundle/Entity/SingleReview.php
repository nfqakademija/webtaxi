<?php

namespace Webtaxi\MainBundle\Entity;

use DateInterval;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Doctrine\ORM\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Webtaxi\MainBundle\Entity\Travel;
use Webtaxi\MainBundle\WebtaxiMainBundle;


class SingleReview
{
    protected $travelId;
    protected $rating;
    protected $comment;
    protected $nameOfReviewer;
    protected $isReviewerAsAClient;

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getIsReviewerAsAClient()
    {
        return $this->isReviewerAsAClient;
    }

    /**
     * @param mixed $isReviewerAsAClient
     */
    public function setIsReviewerAsAClient($isReviewerAsAClient)
    {
        $this->isReviewerAsAClient = $isReviewerAsAClient;
    }

    /**
     * @return mixed
     */
    public function getNameOfReviewer()
    {
        return $this->nameOfReviewer;
    }

    /**
     * @param mixed $nameOfReviewer
     */
    public function setNameOfReviewer($nameOfReviewer)
    {
        $this->nameOfReviewer = $nameOfReviewer;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getTravelId()
    {
        return $this->travelId;
    }

    /**
     * @param mixed $travelId
     */
    public function setTravelId($travelId)
    {
        $this->travelId = $travelId;
    }

    /**
     * @param Travel[] $travels
     * @param $user
     * @return array
     */
    public static function travelsToReviews($travels, $user)
    {
        $reviews = array();
        for ($i = 0; $i<count($travels);$i++) {
            $t = $travels[$i];
            $r = new SingleReview();
            $r->setTravelId($t->getId());
            if ($t->getClient() == $user) {//this means current user was client, so we need driver review:
                $reviewer = $t->getDriver();
                $r->setRating($t->getReviewDriverRating());
                $r->setComment($t->getReviewDriverComment());
                $r->setIsReviewerAsAClient(false);
            } else { // this means current user was driver, so we need client comment:
                $reviewer = $t->getClient();
                $r->setRating($t->getReviewClientRating());
                $r->setComment($t->getReviewClientComment());
                $r->setIsReviewerAsAClient(true);
            }
            $r->setNameOfReviewer('(' . $reviewer->getUsername() . ') ' .
                $reviewer->getFirstName() . ' ' . $reviewer->getLastName() . '');
            $reviews[$i] = $r;
        }
        return $reviews;
    }

}
