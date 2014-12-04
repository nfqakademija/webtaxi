<?php

namespace Webtaxi\MainBundle\Controller;

use Doctrine\DBAL\Types\DateTimeTzType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Webtaxi\MainBundle\Entity\Travel;
use Webtaxi\MainBundle\Form\Type\TravelFormType;


class MapController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $response = $this->render('WebtaxiMainBundle:Main:index.html.twig');
            return $response;
        }

        $travel = new Travel();

        $form = $this->createForm(new TravelFormType(), $travel);

        if ($request != null) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $travel->setTimeCall(new \DateTime());
                $travel->setIsClosed(false);
                $travel->setProfit($travel->getPrice() / $travel->getDistance());

                //probably apskritai neiliseim i si puslapi, jei user null ?
                if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
                    $travel->setClient($this->container->get('security.context')->getToken()->getUser());
                    $em->persist($travel);
                    $em->flush();
//                exit(\Doctrine\Common\Util\Debug::dump($user));
                    return $this->redirect($this->generateUrl('webtaxi_main_findtraveller_index'));
                }
            }
//            if ($form->isSubmitted() === true) {
//                $validator = $this->get('validator');
//                $errors = $validator->validate($travel);
//
//
//                return new Response((string) $errors);
//            }
        }

        return $this->render('WebtaxiMainBundle:Map:index.html.twig', array(
            'form' => $form->createView()
        ));

    }
}
