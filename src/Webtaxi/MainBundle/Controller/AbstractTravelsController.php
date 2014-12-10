<?php

namespace Webtaxi\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webtaxi\MainBundle\Entity\CommunicationHelper\TravelResponse;
use Webtaxi\MainBundle\Entity\Travel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


abstract class AbstractTravelsController extends Controller
{
    const STATUS_TRAVEL_ACTION_OK = 1;
    const STATUS_TRAVEL_NOT_YOURS = -2;
    const STATUS_TRAVEL_ALREADY_ACCEPTED = -3;
    const STATUS_TRAVEL_IS_YOURS_CAN_NOT_ACCEPT = -4;
    const STATUS_TRAVEL_IS_EXPIRED = -6;
    const STATUS_TRAVEL_ACTION_ARGUMENTS_INVALID = -7;

    abstract protected function indexAction();

    abstract protected function getTravels($idFrom, $queryLimit);

    abstract protected function loadMoreTravelsAction(Request $request);

    final public function loadMoreTravels(Request $request)
    {
        //setting params to default values:
        $idFrom = $request->query->get('fromId', -1);
        $queryLimit = $request->query->get('count', 10);


        if ($idFrom <= 0) {
            $idFrom = PHP_INT_MAX;
        }

        $travels = $this->getTravels((int) $idFrom, (int) $queryLimit);

        //converting travels entity to response entity:
        $travels = $this->travelsToResponse($travels);

        // loop through travels and check if current travel is my travel:
        // if its true, it should highlighted in list
        // and also it should be ability to delete it [ToDo]
        $userCurrent = $this->container->get('security.context')->getToken()->getUser();
        for($i = 0; $i < count($travels); $i++)
        {
            $t = $travels[$i];

            //creator of the travel is current user:
            if ($t->getClient() == $userCurrent)
            {
                $t->setIsMyTravel(true);
            }

            //this travel is related to current user:
            if ($t->getClient() == $userCurrent || $t->getDriver() == $userCurrent)
            {
                $t->setIsMyRelatedTravel(true);
            }
        }

        $response = new Response(json_encode(array("travels"=>$travels)));
        return $response;

    }

    /**
     * ajax function for removing my (current user) travel.
     * Checks if travel exists, if client is current user and if it does not have a driver.
     *
     * @Route("/removeMyTravel/{travel}")
     * @param Travel $travel
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    final public function removeMyTravelAction(Travel $travel)
    {
        //if travel client is not current user, error:
        if ($travel->getClient() != $this->getUser()) {
            return toJsonResponse(AbstractTravelsController::STATUS_TRAVEL_NOT_YOURS,
                "Jūs negalite trinti ne savo kelionę");
        }
        //if traval has a driver, it could not be canceled, error:
        if ($travel->getDriver() != null) {
            return toJsonResponse(AbstractTravelsController::STATUS_TRAVEL_ALREADY_ACCEPTED,
                "Ši kelionė jau priimta, jos trinti nebegalima");
//            return toJsonResponse(AbstractTravelsController::, "");
        }
        //if travel is expired, error:
        if ($travel->isTravelExpired()) {
            return toJsonResponse(AbstractTravelsController::STATUS_TRAVEL_IS_EXPIRED,
                "Ši kelionė sukurta labai seniai. Ji nebegalioja ir jos trinti nebegalima");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($travel);
        $em->flush();
        return toJsonResponse(AbstractTravelsController::STATUS_TRAVEL_ACTION_OK,
            "Jūsų kelionė buvo sėkmingai ištrinta");

    }

    /**
     * @param Travel $travels[]
     * @return TravelResponse $travelResponse[]
     */
    final static function travelsToResponse($travels) {
        $travelResponse = array();
        for ($i = 0;$i<count($travels);$i++) {
            $t = $travels[$i];
            $tr = new TravelResponse($t);
            $travelResponse[$i] = $tr;
        }
        return $travelResponse;
    }

    public static function toJsonResponse($status, $message) {
        return new Response(json_encode(array("status" => $status, "message" => $message)));
    }

}
