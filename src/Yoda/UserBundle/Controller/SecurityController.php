<?php

namespace Yoda\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

//usse \Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController extends Controller {
    // creating annotation routes

    /**
     * @Route("/login", name="login_form")
     */
    public function loginAction(Request $request) {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('UserBundle:Security:login.html.twig', array(
                    'last_username' => $lastUsername,
                    'error' => $error,
        ));
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction() {
        // empty
    }
    
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction() {
        // empty
    }

}
