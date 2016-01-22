<?php

namespace Infrastructure\RabbitMq;

use PhpAmqpLib\Message\AMQPMessage;
use Queue\Producer\HelloProducerInterface;

class HelloProducer extends RabbitMqClient implements HelloProducerInterface
{
    public function produce()
    {
        $this->channel->queue_declare($this->queueName, false, false, false, false);

        $msg = new AMQPMessage('Hello World!');
        $this->channel->basic_publish($msg, '', $this->queueName);
    }
}
