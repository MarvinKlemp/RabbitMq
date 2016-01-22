<?php

namespace AppBundle\Command;

use Queue\Consumer\ConsumeHelloToLogs;
use Infrastructure\RabbitMq\MessageTransformer\HelloMessageTransformer;
use Infrastructure\RabbitMq\Processor\HelloMessageProcessor;
use Infrastructure\RabbitMq\Runner\ConsumerRunner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsumeHelloToLogsCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('queue:consume:logs')
            ->setDescription('log your greetings')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $consumer = new ConsumeHelloToLogs();
        $transformer = new HelloMessageTransformer();
        $processor = new HelloMessageProcessor($consumer, $transformer);
        $runner = new ConsumerRunner('hello_logs', $processor);

        $runner->run();
    }
}
