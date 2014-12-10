<?php

namespace Webtaxi\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webtaxi\MainBundle\Controller\AbstractTravelsControler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Webtaxi\MainBundle\Entity\Travel;


class MyTravelHistoryController extends AbstractTravelsController
{
    const STATUS_TRAVEL_REVIEW_GIVEN = -11;

    /**
     * @Route("/mytravelhistory")
     * @Template()
     */
    public function indexAction()
    {
        $response = $this->render('WebtaxiMainBundle:MyTravelHistory:index.html.twig');
        return $response;
    }

    /**
     * ajax function for getting more travells. Ajax params are:
     * fromId - id followed by to select;
     * count - limit in query
     *
     * @Route("/mytravelhistory/loadMoreTravels")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response json array of travells, which match criteria
     */
    public function loadMoreTravelsAction(Request $request)
    {
        return $this->loadMoreTravels($request);
    }

    /**
     * ajax function for reviewing my travel.
     *
     * @Route("/reviewTravel/{travel}")
     * @param Travel $travel
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reviewTravelAction(Travel $travel, Request $request)
    {
        $rating = $request->get('rating', 0);
        $comment = $request->get('comment', '');

        // if rating is not between [1, 5] and if comment length is more than 255 symbols, error:
        if ($rating <= 0  || $rating > 5 || $comment == '' || strlen($comment) > 255) {
            return $this->toJsonResponse(AbstractTravelsController::STATUS_TRAVEL_ACTION_ARGUMENTS_INVALID,
                "Netinkami užklausos parametrai  ir/arba jų reikšmes. " . $rating . " " . $comment);
        }

        $user = $this->getUser();
        $reviewWasAleadyGiven = false;
        $isUserAsAClient = $travel->isUserClient($user);
        $isUserAsADriver = $travel->isUserDriver($user);
        // this travel is not related to current user:
        if (!$isUserAsAClient && !$isUserAsADriver) {
            return $this->toJsonResponse(AbstractTravelsController::STATUS_TRAVEL_NOT_YOURS,
                "Jūs negalite vertinti ne savo kelionių");
        }
        if ($isUserAsAClient) {
            if ($travel->isClientReviewGiven()) {
                $reviewWasAleadyGiven = true;
            } else {
                $travel->setReviewClientRating($rating);
                $travel->setReviewClientComment($comment);
            }
        }
        if ($isUserAsADriver) {
            if ($travel->isDriverReviewGiven()) {
                $reviewWasAleadyGiven = true;
            } else {
                $travel->setReviewDriverRating($rating);
                $travel->setReviewDriverComment($comment);
            }
        }
        // review already was given before, error:
        if ($reviewWasAleadyGiven) {
            return $this->toJsonResponse(AbstractTravelsController::STATUS_TRAVEL_REVIEW_GIVEN, "Šios kelionės vertinimą jau atlikote");
        }

        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->toJsonResponse(AbstractTravelsController::STATUS_TRAVEL_ACTION_OK, "Ačiū. Vertinimas išsaugotas");
    }

    /**
     * returns array of some more travels to show in My Travels section
     * @param $idFrom
     * @param $queryLimit
     * @return mixed
     */
    protected function getTravels($idFrom, $queryLimit)
    {
        $travels = $this->getDoctrine()->
        getRepository('WebtaxiMainBundle:Travel')
            ->getMyTravels($this->getUser(), $idFrom, (int) $queryLimit);
        return $travels;
    }
}
