<?php

namespace Yoda\EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Yoda\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsers implements FixtureInterface, ContainerAwareInterface
{
    /**
     *
     * @var ContainerInterface
     */
    private $container;
    
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('user');
        $user->setEmail('user@user.com');
        $user->setPassword($this->encodePassword($user, '12345'));
        $manager->persist($user);
        
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@admin.com');
        $admin->setPassword($this->encodePassword($admin, '12345'));
        $admin->setRoles(array('ROLE_ADMIN'));
//        $admin->setIsActive(false);
        $manager->persist($admin);
        
        $manager->flush();
    }
    
    public function encodePassword(User $user, $plainpasseord){
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        
        return $encoder->encodePassword($plainpasseord, $user->getSalt());
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }

}