<?php

namespace AppBundle\Controller;

use AppBundle\Entity\GuestBookMessage;
use AppBundle\Form\GuestBookMessageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
            'message_form' => $this->createMessageForm()->createView(),
        ]);
    }

    /**
     * @Route(path="/message/new", name="new_message")
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function addMessageAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $messagesRepo = $manager->getRepository('AppBundle:GuestBookMessage');

        $entity = new GuestBookMessage();
        $messageForm = $this->createMessageForm($entity);

        $messageForm->handleRequest($request);

        if ($messageForm->isValid()) {

            $manager->persist($entity);
            $manager->flush();

            $this->get('session')->getFlashBag()->add('success', 'Message was published!');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/index.html.twig', [
            'messages' => $messagesRepo->findAll(),
            'message_form' => $messageForm->createView(),
        ]);
    }

    /**
     * @param GuestBookMessage|null $entity
     * @return Form
     */
    private function createMessageForm($entity = null)
    {
        return $this->createForm(GuestBookMessageType::class, $entity, [
            'action' => $this->generateUrl('new_message'),
        ]);
    }
}
