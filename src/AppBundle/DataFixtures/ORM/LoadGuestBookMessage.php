<?php

namespace AppBundle\DataFixtures\ORM;
use AppBundle\Entity\GuestBookMessage;
use AppBundle\GuestBook\MessageCreator;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGuestBookMessage implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $systemMessage = new GuestBookMessage();
        $systemMessage
            ->setText('Welcome to guest book!')
            ->setUsername(MessageCreator::SYSTEM_MESSAGE);
        $manager->persist($systemMessage);

        $message = new GuestBookMessage();
        $message
            ->setText('My first message. Yay!')
            ->setUsername('Maks')
            ->setEmail('email@gmail.com');
        $manager->persist($message);

        $manager->flush();
    }
}
