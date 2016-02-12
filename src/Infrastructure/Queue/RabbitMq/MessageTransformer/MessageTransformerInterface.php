<?php

namespace Infrastructure\Queue\RabbitMq\MessageTransformer;

use Infrastructure\Queue\Messages\MessageInterface;
use PhpAmqpLib\Message\AMQPMessage;

interface MessageTransformerInterface
{
    /**
     * @param AMQPMessage $message
     * @return MessageInterface
     */
    public function transform(AMQPMessage $message);

    /**
     * @param MessageInterface $message
     * @return AMQPMessage
     */
    public function reverseTransform(MessageInterface $message);
}
