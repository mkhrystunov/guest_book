<?php

namespace AppBundle\Doctrine;

use AppBundle\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class UserListener
{
    /** @var EncoderFactory */
    private $encoderFactory;

    /**
     * @param EncoderFactory $encoderFactory
     */
    public function __construct(EncoderFactory $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        if ($user = $this->getUser($eventArgs)) {
            $this->handleUserChange($user);
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        if ($user = $this->getUser($eventArgs)) {
            $this->handleUserChange($user);
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     * @return null|User
     */
    private function getUser(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof User) {
            return $entity;
        }
        return null;
    }

    /**
     * @param User $user
     */
    private function handleUserChange(User $user)
    {
        if (!$plainPassword = $user->getPlainPassword()) {
            return;
        }
        $encoder = $this->encoderFactory->getEncoder($user);

        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password);
    }
}
