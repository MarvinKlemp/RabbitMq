<?php

namespace Infrastructure\RabbitMq\Producer;

use Infrastructure\RabbitMq\MessageTransformer\HelloMessageTransformer;
use Infrastructure\RabbitMq\RabbitMqPublisher;
use Queue\HelloMessage;
use Queue\Producer\HelloProducerInterface;

class HelloProducer extends RabbitMqPublisher implements HelloProducerInterface
{
    /**
     * @var HelloMessageTransformer
     */
    private $messageTransformer;

    public function __construct(HelloMessageTransformer $messageTransformer)
    {
        $this->messageTransformer = $messageTransformer;

        parent::__construct();
    }

    public function produce(HelloMessage $message)
    {
        $this->channel->basic_publish(
            $this->messageTransformer->reverseTransform($message),
            $this->exchangeName
        );
    }
}
