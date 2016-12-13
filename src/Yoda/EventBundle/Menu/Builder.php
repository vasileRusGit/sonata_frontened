<?php

namespace Yoda\EventBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Yoda\EventBundle\Entity\Event;

class Builder extends Controller implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => 'event_index_user'));

        // access services from the container!
        $em = $this->getDoctrine()->getManager();
        // findMostRecent and Blog are just imaginary examples
        $blog = $em->getRepository('EventBundle:Event')->findAll();

        $menu->addChild('Latest Blog Post', array(
            'route' => 'event_index_user',
//            'routeParameters' => array('id' => $blog->getId())
        ));

        return $menu;
    }
}