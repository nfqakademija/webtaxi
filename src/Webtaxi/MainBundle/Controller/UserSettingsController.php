<?php

namespace Webtaxi\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UserSettingsController extends Controller
{
    /**
     * @Route("/usersettings")
     * @Template()
     */
    public function indexAction()
    {
        $args = array("name" => "Greta", "userFirstName"=>"Greta", "userLastName"=>"Radišauskaitė", "userEmail"=>"ger@fdf.lt");
        $response = $this->render('WebtaxiMainBundle:UserSettings:index.html.twig', $args);
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }
}
