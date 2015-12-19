<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearMessagesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('messages:clear')
            ->setDescription('Delete old messages')
            ->addArgument(
                'amount',
                InputArgument::REQUIRED,
                'Amount of messages to delete'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $amount = $input->getArgument('amount');
        $repository = $this->getContainer()->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:GuestBookMessage');

        $repository->deleteOldMessages($amount);
    }
}
