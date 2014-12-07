<?php

namespace Webtaxi\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Webtaxi\MainBundle\Entity\Travel;
use Webtaxi\MainBundle\Controller\AbstractTravelsControler;

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
        //if travel client is current user, error:
        if ($travel->getClient() == $this->getUser()) {
            return new Response(json_encode(array("status" => -4, "message" => "Negalite priimti savo paties kelionės")));
        }
        //if travel already has a driver, it could not be accepted, error:
        if ($travel->getDriver() != null) {
            return new Response(json_encode(array("status" => -5, 'message' => "Deja, ši kelionė jau turi vairuotoją")));
        }
        $travel->setDriver($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return new Response(json_encode(array("status" => 1, 'message' => "Jūs priėmėte šią kelionę")));

    }

    protected function getTravels($idFrom, $queryLimit)
    {
        $travels = $this->getDoctrine()->
        getRepository('WebtaxiMainBundle:Travel')
            ->getNotAcceptedTravelsAfterId($idFrom, (int) $queryLimit);
        return $travels;
    }

}
