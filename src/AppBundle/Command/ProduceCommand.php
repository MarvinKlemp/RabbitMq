<?php

namespace AppBundle\Command;

use Infrastructure\RabbitMq\Producer\HelloProducer;
use Queue\HelloMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProduceCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('queue:greet')
            ->setDescription('Greet someone far away')
            ->addArgument(
                'count',
                InputArgument::OPTIONAL,
                'how often do you want to greet?',
                1
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $producer = new HelloProducer();
        $count = $input->getArgument('count');

        for ($i = 1;$i <= $count;$i++) {
            $producer->produce(new HelloMessage($i . '/' . $count));
        }
    }
}
