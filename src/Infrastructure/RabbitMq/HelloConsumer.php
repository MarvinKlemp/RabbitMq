<?php

namespace Infrastructure\RabbitMq;

use Queue\Consumer\HelloConsumerInterface;

class HelloConsumer extends RabbitMqClient implements HelloConsumerInterface
{
    public function consume()
    {
        $this->channel->queue_declare($this->queueName, false, false, false, false);

        $callback = function($msg) {
            echo "[x] Received ", $msg->body, "\n";
        };

        $this->channel->basic_consume($this->queueName, '', false, true, false, false, $callback);

        while(count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }
}
