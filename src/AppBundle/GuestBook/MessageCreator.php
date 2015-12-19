<?php

namespace  AppBundle\GuestBook;

use AppBundle\Entity\GuestBookMessage;
use Doctrine\ORM\EntityManagerInterface;

class MessageCreator
{
    const SYSTEM_MESSAGE = 'System';

    /** @var EntityManagerInterface */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function createMessage($text, $username, $email = null)
    {
        $message = new GuestBookMessage();
        $message
            ->setText($text)
            ->setUsername($username)
            ->setEmail($email);

        $this->manager->persist($message);
        $this->manager->flush();
    }
}
