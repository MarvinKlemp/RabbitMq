<?php

namespace Infrastructure\RabbitMq;

use Queue\Consumer\HelloConsumerInterface;

class HelloConsumer extends RabbitMqClient implements HelloConsumerInterface
{
    public function consume()
    {
        $this->channel->queue_declare($this->queueName, false, false, false, false);

        $callback = function($msg) {
            echo "recieved: " . $msg->body . "\n";
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };

        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume($this->queueName, '', false, false, false, false, $callback);

        while(count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }
}
