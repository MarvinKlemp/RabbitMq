<?php

namespace Infrastructure\RabbitMq;

use PhpAmqpLib\Message\AMQPMessage;
use Queue\HelloMessage;
use Queue\Producer\HelloProducerInterface;

class HelloProducer extends RabbitMqClient implements HelloProducerInterface
{
    public function produce(HelloMessage $message)
    {
        $this->channel->queue_declare($this->queueName, false, false, false, false);

        $msg = new AMQPMessage($message->body(), ['delivery_mode' => 2]);

        $this->channel->basic_publish($msg, '', $this->queueName);
    }
}
