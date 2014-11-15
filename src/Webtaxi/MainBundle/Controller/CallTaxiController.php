<?php

namespace Webtaxi\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \FOS\UserBundle\Controller\SecurityController as BaseController;

class CallTaxiController extends BaseController
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
