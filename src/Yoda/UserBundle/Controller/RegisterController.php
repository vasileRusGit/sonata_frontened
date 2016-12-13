<?php

namespace Yoda\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Yoda\UserBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class RegisterController extends Controller
{

    /**
     * @Route("/register", name="user_register")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('username', 'text', array('label' => false))
            ->add('email', 'email', array('label' => false))
            ->add('password', 'repeated', array('type' => 'password', 'first_options' => array('label' => false), 'second_options' => array('label' => false)))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $user = new User();
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);
            $user->setPassword($this->encodePassword($user, $data['password']));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $url = $this->generateUrl('event_index');

            return $this->redirect($url);
        }

        return $this->render('@User/Register/registration.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/user_edit/{id}", name="user_edit")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id, Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('username', 'text', array('label' => false))
            ->add('email', 'email', array('label' => false))
            ->add('password', 'repeated', array('type' => 'password', 'required' => false, 'first_options' => array('label' => false), 'second_options' => array('label' => false, 'required' => false)))
            ->getForm();

        $form->handleRequest($request);

        $user = $this->getDoctrine()->getRepository('UserBundle:User')->find($id);

        $user->setUsername($user->getUsername());
//        dump($user->getUsername());die;
        $user->setEmail($user->getEmail());


        if ($form->isSubmitted() && $form->isValid()) {
            $username = $form['username']->getData();
            $email = $form['email']->getData();
            $password = $form['password']->getData();

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('UserBundle:User')->find($id);

            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($this->encodePassword($user, $password));

            $em->persist($user);
            $em->flush();

            $url = $this->generateUrl('event_index');
            return $this->redirect($url);
        }
        return $this->render('@User/Register/edit_account.html.twig', array('user' => $user, 'form' => $form->createView()));
    }

    public function encodePassword(User $user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

}
