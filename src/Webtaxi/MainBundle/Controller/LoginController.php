<?php

namespace Webtaxi\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class LoginController extends Controller
{
    /**
     * @Route("/login2")
     * @Template()
     */
    public function indexAction()
    {

        $response = $this->render('WebtaxiMainBundle:Login:index.html.twig');
        return $response;
    }
}
