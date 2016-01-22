<?php

namespace AppBundle\Command;

use Infrastructure\RabbitMq\HelloConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsumeCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('queue:consume')
            ->setDescription('Get your greetings')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $consumer = new HelloConsumer();
        $consumer->consume();
    }
}
