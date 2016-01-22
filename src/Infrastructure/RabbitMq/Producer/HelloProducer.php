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

    /**
     * @param HelloMessageTransformer $messageTransformer
     * @param string $exchangeName
     */
    public function __construct(HelloMessageTransformer $messageTransformer, $exchangeName)
    {
        $this->messageTransformer = $messageTransformer;

        parent::__construct($exchangeName);
    }

    /**
     * @param HelloMessage $message
     */
    public function produce(HelloMessage $message)
    {
        $this->channel->basic_publish(
            $this->messageTransformer->reverseTransform($message),
            $this->exchangeName
        );
    }
}
