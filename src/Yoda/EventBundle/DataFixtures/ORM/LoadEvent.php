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
        $event1->setLocation('Los Angeles');
        $event1->setTime(new \DateTime('tomorrow noon'));
        $event1->setDetails('This is the first fixture');
        $manager->persist($event1);
        
        $event2 = new Event();
        $event2->setName('Fixture2');
        $event2->setLocation('New York');
        $event2->setTime(new \DateTime('tomorrow noon'));
        $event2->setDetails('This is the first fixture');
        $manager->persist($event2);
        
        $manager->flush();
    }
}