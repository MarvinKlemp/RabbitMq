<?php

namespace Infrastructure\RabbitMq\Producer;

use Infrastructure\RabbitMq\RabbitMqPublisher;
use PhpAmqpLib\Message\AMQPMessage;
use Queue\HelloMessage;
use Queue\Producer\HelloProducerInterface;

class HelloProducer extends RabbitMqPublisher implements HelloProducerInterface
{
    public function produce(HelloMessage $message)
    {
        $msg = new AMQPMessage($message->body(), ['delivery_mode' => 2]);

        $this->channel->basic_publish($msg, $this->exchangeName);
    }
}
