<?php

namespace Webtaxi\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Webtaxi\MainBundle\Entity\Travel;


class FindTravellerController extends Controller
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
     * @Route("/loadMoreTravels")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response json array of travells, which match criteria
     */
    public function loadMoreTravelsAction(Request $request)
    {
        //setting params to default values:
        $idFrom = $request->query->get('fromId', -1);
        $queryLimit = $request->query->get('count', 10);


        if ($idFrom <= 0) {
            $idFrom = PHP_INT_MAX;
        }
        $travels = $this->getDoctrine()->
        getRepository('WebtaxiMainBundle:Travel')
            ->getNotAcceptedTravelsAfterId($idFrom, (int) $queryLimit);

        // loop through travels and check if current travel is my travel:
        // if its true, it should highlighted in list
        // and also it should be ability to delete it [ToDo]
        $userCurrent = $this->container->get('security.context')->getToken()->getUser();
        for($i = 0; $i < count($travels); $i++)
        {
            $t = $travels[$i];
            if ($t->getClient() == $userCurrent)
            {
                $t->setIsMyTravel(true);
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
    public function removeMyTravelAction(Travel $travel)
    {
        //if travel client is not current user, error:
        if ($travel->getClient() != $this->getUser()) {
            return new Response(json_encode(array("status" => -2, "message" => "Jūs negalite trinti ne savo kelionę")));
        }
        //if traval has a driver, it could not be canceled, error:
        if ($travel->getDriver() != null) {
            return new Response(json_encode(array("status" => -3, "message" => "Ši kelionė jau priimta, jos trinti nebegalima")));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($travel);
        $em->flush();
        return new Response(json_encode(array("status" => 1, "message" => "Jūsų kelionė buvo sėkmingai ištrinta")));

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
}
