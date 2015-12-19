<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUsers implements FixtureInterface
{
    const TEST_USER_USERNAME = 'admin';
    const TEST_USER_PASSWORD = 'adminpass';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setUsername(self::TEST_USER_USERNAME)
            ->setPlainPassword(self::TEST_USER_PASSWORD)
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
        $manager->flush();
    }
}
