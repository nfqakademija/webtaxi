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


class MyTravelHistoryController extends AbstractTravelsController
{
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
    public function loadMoreTravelsAction(Request $request) {
        return $this->loadMoreTravels($request);
    }

    protected function getTravels($idFrom, $queryLimit)
    {
        $travels = $this->getDoctrine()->
        getRepository('WebtaxiMainBundle:Travel')
            ->getMyTravels($this->getUser(), $idFrom, (int) $queryLimit);
        return $travels;
    }

}
