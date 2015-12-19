<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function indexAction()
    {
        $manager = $this->getDoctrine()->getManager();
        $messagesRepo = $manager->getRepository('AppBundle:GuestBookMessage');

        return $this->render('default/index.html.twig', [
            'messages' => $messagesRepo->findAll(),
        ]);
    }
}
