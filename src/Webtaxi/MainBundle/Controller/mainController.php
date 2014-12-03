<?php

namespace Webtaxi\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class mainController extends Controller
{
    /**
     * @Route("/home")
     * @Template()
     */
    public function indexAction()
    {

        $response = $this->render('WebtaxiMainBundle:Main:index.html.twig');
        return $response;
    }
}
