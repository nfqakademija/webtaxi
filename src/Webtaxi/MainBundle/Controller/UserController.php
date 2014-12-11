<?php

namespace Webtaxi\MainBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Webtaxi\MainBundle\Entity\SingleReview;
use Webtaxi\MainBundle\Entity\User;
use Webtaxi\MainBundle\Entity\TravelRepository;

class UserController extends Controller
{
    /**
     * @Route("/user/{user}")
     * @param User $user
     * @Template()
     */
    public function indexAction(User $user)
    {
        $reviews = UserController::getReviewsGivenToThisUser($this, $user);

        $response = $this->render('WebtaxiMainBundle:User:index.html.twig', array(
        'user' => $user, 'reviews' => $reviews, 'isCurrentUser'=>false));
        return $response;

    }

    public static function getReviewsGivenToThisUser($thisObj, User $user) {
        $repTravels = $thisObj->getDoctrine()->getRepository('WebtaxiMainBundle:Travel');
        if (!$repTravels instanceof TravelRepository) {
            throw new InvalidTypeException('must return correct TravelRepository');
        }
        $travels = $repTravels->getLastRelatedTravels($user, 20);
        return SingleReview::travelsToReviews($travels, $user);
    }
}
