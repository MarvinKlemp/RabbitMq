<?php

namespace Infrastructure\RabbitMq\Processor;

use Infrastructure\RabbitMq\MessageTransformer\HelloMessageTransformer;
use PhpAmqpLib\Message\AMQPMessage;
use Queue\Consumer\ConsumingException;
use Queue\Consumer\HelloConsumerInterface;

class HelloMessageProcessor
{
    /**
     * @var HelloConsumerInterface
     */
    private $consumer;
    /**
     * @var HelloMessageTransformer
     */
    private $messageTransformer;

    /**
     * @param HelloConsumerInterface $consumer
     * @param HelloMessageTransformer $messageTransformer
     */
    public function __construct(HelloConsumerInterface $consumer, HelloMessageTransformer $messageTransformer)
    {
        $this->consumer = $consumer;
        $this->messageTransformer = $messageTransformer;
    }

    public function process(AMQPMessage $message)
    {
        try {
            $helloMessage = $this->messageTransformer->transform($message);
            $this->consumer->consume($helloMessage);
        } catch (ConsumingException $e) {
            return;
        }

        $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
    }
}
