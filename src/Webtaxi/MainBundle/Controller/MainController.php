<?php

namespace Webtaxi\MainBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MainController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            $response = $this->render('WebtaxiMainBundle:Main:index.html.twig');
            return $response;
        }

        $url = $this->generateUrl('webtaxi_main_map_index');
        $response = new RedirectResponse($url);
        return $response;

    }
}
