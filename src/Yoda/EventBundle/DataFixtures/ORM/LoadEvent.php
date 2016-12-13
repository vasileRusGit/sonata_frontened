<?php

namespace Yoda\EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Yoda\EventBundle\Entity\Event;

class LoadEventa implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $event1 = new Event();
        $event1->setName('Fixture1');
        $event1->setMark('BMW');
        $event1->setType('motor');
        $event1->setDetails('This is the first fixture');
        $manager->persist($event1);
        
        $event2 = new Event();
        $event2->setName('Fixture2');
        $event2->setMark('AUDI');
        $event2->setType('Bord');
        $event2->setDetails('This is the first fixture');
        $manager->persist($event2);
        
        $manager->flush();
    }
}