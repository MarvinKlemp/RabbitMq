<?php

namespace Infrastructure\RabbitMq\Runner;

use Infrastructure\RabbitMq\Processor\HelloMessageProcessor;
use Infrastructure\RabbitMq\RabbitMqSubscriber;

class ConsumerRunner extends RabbitMqSubscriber
{
    /**
     * @var HelloMessageProcessor
     */
    private $processor;

    /**
     * @param string $queueName
     * @param string $exchangeName
     * @param HelloMessageProcessor $processor
     */
    public function __construct($queueName, $exchangeName, HelloMessageProcessor $processor)
    {
        parent::__construct($queueName, $exchangeName);
        $this->processor = $processor;
    }

    public function run()
    {
        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume($this->queueName, '', false, false, false, false, [$this->processor, 'process']);

        while(count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }
}
