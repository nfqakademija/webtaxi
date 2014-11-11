<?php

namespace Webtaxi\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CallTaxiController extends Controller
{
    /**
     * @Route("/calltaxi")
     * @Template()
     */
    public function indexAction()
    {
        //$args = array("name" => "Greta");
        $response = $this->render('WebtaxiMainBundle:CallTaxi:index.html.twig');
        return $response;
    }

}
