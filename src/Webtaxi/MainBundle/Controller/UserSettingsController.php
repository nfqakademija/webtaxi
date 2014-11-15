<?php

namespace Webtaxi\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Console\Logger\ConsoleLogger;

class UserSettingsController extends Controller
{
    /**
     * @Route("/usersettings")
     * @Template()
     */
    public function indexAction()
    {
        $args = array("name" => "Greta", "userFirstName"=>"Greta", "userLastName"=>"Radišauskaitė", "userEmail"=>"ger@fdf.lt");
        die("fuck this shit");
        $nameNew = $this->get('request')->request->get('userFirstName');
        $nameSecondNew = $this->get('request')->request->get('userLastName');
        $emailNew = $this->get('request')->request->get('userEmail');
//        $file = $this->get('request')->request->get('pic');


        $response = $this->render('WebtaxiMainBundle:UserSettings:index.html.twig');
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }

}
