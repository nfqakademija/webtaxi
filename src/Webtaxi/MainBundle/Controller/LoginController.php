<?php

namespace Webtaxi\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class LoginController extends Controller
{
    /**
     * @Route("/login")
     * @Template()
     */
    public function indexAction()
    {
        $args = array("name" => "Greta");
        $response = $this->render('WebtaxiMainBundle:Login:index.html.twig', $args);
        return $response;
    }
}
