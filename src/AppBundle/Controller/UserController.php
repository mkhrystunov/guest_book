<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Event\UserRegisteredEvent;
use AppBundle\Form\RegisterFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends Controller
{
    const PROVIDER_KEY = 'secured_area';

    /**
     * @Route("/login", name="login_form")
     * @Template()
     *
     * @return array
     */
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');

        return [
            'last_username' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError(),
        ];
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        throw new \Exception('This should never be reached');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        throw new \Exception('This should never be reached');
    }

    /**
     * @Route("/register", name="register")
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function registerAction(Request $request)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }
        $user = new User();
        $form = $this->createForm(RegisterFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->get('event_dispatcher')->dispatch(UserRegisteredEvent::NAME, new UserRegisteredEvent($user));
            $this->get('session')->getFlashBag()->add('success', 'You have successfully registered!');

            $key = '_security.' . self::PROVIDER_KEY . '.target_path';
            $session = $request->getSession();

            if ($session->has($key)) {
                $url = $session->get($key);
                $session->remove($key);
            } else {
                $url = $this->generateUrl('homepage');
            }

            return $this->redirect($url);
        }

        return [
            'user' => $user,
            'form' => $form->createView(),
        ];
    }
}
