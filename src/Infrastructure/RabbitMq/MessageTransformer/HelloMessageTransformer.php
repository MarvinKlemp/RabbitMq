<?php

namespace Infrastructure\RabbitMq\MessageTransformer;

use PhpAmqpLib\Message\AMQPMessage;
use Queue\HelloMessage;

class HelloMessageTransformer
{
    /**
     * @param AMQPMessage $message
     * @return HelloMessage
     */
    public function transform(AMQPMessage $message)
    {
        return new HelloMessage($message->body);
    }

    /**
     * @param HelloMessage $message
     * @return AMQPMessage
     */
    public function reverseTransform(HelloMessage $message)
    {

    }
}
