<?php

namespace AppBundle\EventListener;

use AppBundle\Event\UserRegisteredEvent;
use AppBundle\GuestBook\MessageCreator;

class UserListener
{
    /** @var MessageCreator */
    private $messageCreator;

    /**
     * @param MessageCreator $messageCreator
     */
    public function __construct(MessageCreator $messageCreator)
    {
        $this->messageCreator = $messageCreator;
    }

    public function onRegistered(UserRegisteredEvent $event)
    {
        $user = $event->getUser();

        $this->messageCreator->createMessage(
            sprintf('Welcome new user — %s!', $user->getUsername()),
            MessageCreator::SYSTEM_MESSAGE
        );
    }
}
