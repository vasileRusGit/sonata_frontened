<?php

namespace Yoda\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    public function layoutAction($name) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('EventBundle:Event');
        
        $eventName = $repository->findOneBy(array('name' => 'first'));
        
        return $this->render('EventBundle:Default:layout.html.twig', array('name' => $name, 'eventName' => $eventName));
    }

}
