<?php

namespace Webtaxi\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webtaxi\MainBundle\Entity\Travel;
use Webtaxi\MainBundle\Controller\AbstractTravelsControler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Webtaxi\MainBundle\Entity\TravelRepository;

class FindTravellerController extends AbstractTravelsController
{
    /**
     * @Route("/findtraveller")
     * @Template()
     */
    public function indexAction()
    {
        $response = $this->render('WebtaxiMainBundle:FindTraveller:index.html.twig');
        return $response;
    }

    /**
     * ajax function for getting more travells. Ajax params are:
     * fromId - id followed by to select;
     * count - limit in query
     *
     * @Route("/findtraveller/loadMoreTravels")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response json array of travells, which match criteria
     */
    public function loadMoreTravelsAction(Request $request) {
        return $this->loadMoreTravels($request);
    }

    /**
     * ajax function for accepting a travel
     * Checks if travel exists, if client is not a current user and if it does not have a driver.
     *
     * @Route("/acceptTravel/{travel}")
     * @param Travel $travel
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function acceptTravelAction(Travel $travel)
    {
        //if current user did not set car license plate:
        $user = $this->getUser();
//        $licensePlate = $user->getCarLicensePlate;
//        if ($licensePlate == null || strlen($licensePlate) == 0) {
//            return toJsonResponse(AbstractTravelsController::STATUS_TRAVEL_IS_YOURS_CAN_NOT_ACCEPT,
//                "Jūs nepridėjote savo automobilio numerio, todėl negalite priimti kelionės.
//                Nueikite į nustatymus ir pridėkite");
//        }
        //

        //if travel client is current user, error:
        if ($travel->getClient() == $this->getUser()) {
            return $this->toJsonResponse(AbstractTravelsController::STATUS_TRAVEL_IS_YOURS_CAN_NOT_ACCEPT,
                "Negalite priimti savo paties kelionės");
        }
        //if travel already has a driver, it could not be accepted, error:
        if ($travel->getDriver() != null) {
            return $this->toJsonResponse(AbstractTravelsController::STATUS_TRAVEL_ALREADY_ACCEPTED,
                "Deja, ši kelionė jau turi vairuotoją");
        }
        //if travel is expired, error:
        if ($travel->isTravelExpired()) {
            return $this->toJsonResponse(AbstractTravelsController::STATUS_TRAVEL_IS_EXPIRED,
                "Ši kelionė sukurta labai seniai. Ji nebegalioja ir jos priimti nebegalima");
        }

        $travel->setDriver($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->toJsonResponse(AbstractTravelsController::STATUS_TRAVEL_ACTION_OK, "Jūs priėmėte šią kelionę");

    }

    protected function getTravels($idFrom, $queryLimit)
    {
        $repTravels = $this->getDoctrine()->
        getRepository('WebtaxiMainBundle:Travel');
        if (!$repTravels instanceof TravelRepository) {
            throw new InvalidTypeException('must return correct TravelRepository');
        }
        $travels = $repTravels
            ->getNotAcceptedTravelsAfterId($idFrom, (int) $queryLimit);
        return $travels;
    }

}
