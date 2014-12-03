<?php

namespace Webtaxi\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $queryLimit = 10;
        $idFrom = -1;


        $paramsString = $request->getContent();

        if ($paramsString != null)
        {
            $params = explode("&", $paramsString);
            for ($i=0; $i < count($params) ; $i++)
            {
                $pair = explode("=", $params[$i]);
                $name = $pair[0];
                $value = $pair[1];
                if ($name == "count")
                {
                    $queryLimit = (int) $value;
                } else
                if ($name == "fromId") {
                    $idFrom = (int) $value;
                }
            }
        }

        if ($idFrom >= 0)
        {
            $travels = $this->getDoctrine()->
                getRepository('WebtaxiMainBundle:Travel')
                ->getTravelsAfterId($idFrom, (int) $queryLimit);
        } else
        {
            $travels = $this->getDoctrine()
                ->getRepository('WebtaxiMainBundle:Travel')
                ->findBy(array(),
                    array('timeCall' => 'DESC'),
                    (int) $queryLimit);
        }

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
}
