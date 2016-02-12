<?php

namespace Infrastructure\Queue\RabbitMq\MessageTransformer;

use Infrastructure\Queue\Messages\MessageInterface;
use PhpAmqpLib\Message\AMQPMessage;

class RequestInfoMessageTransformer implements MessageTransformerInterface
{
    public function transform(AMQPMessage $message)
    {
    }

    public function reverseTransform(MessageInterface $message)
    {
    }
}