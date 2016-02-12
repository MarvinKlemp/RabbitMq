<?php

namespace Infrastructure\Queue\RabbitMq;

use Infrastructure\Queue\Consumer\ConsumerInterface;
use Infrastructure\Queue\Consumer\ConsumingException;
use Infrastructure\Queue\RabbitMq\MessageTransformer\MessageTransformerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class Processor
{
    /**
     * @var MessageTransformerInterface
     */
    private $messageTransformer;
    /**
     * @var ConsumerInterface
     */
    private $consumer;
    /**
     * @var bool
     */
    private $ack;

    /**
     * @param MessageTransformerInterface $messageTransformer
     * @param ConsumerInterface $consumer
     * @param bool $ack
     */
    public function __construct(MessageTransformerInterface $messageTransformer, ConsumerInterface $consumer, $ack = true)
    {
        $this->messageTransformer = $messageTransformer;
        $this->consumer = $consumer;
        $this->ack = $ack;
    }

    /**
     * @param AMQPMessage $message
     */
    public function process(AMQPMessage $message)
    {
        try {
            $message = $this->messageTransformer->transform($message);
            $this->consumer->consume($message);
        } catch (ConsumingException $e) {
            /** @todo error handling the message has to be removed from queue */
            return;
        }

        if (true === $this->ack) {
            $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
        }
    }
}
