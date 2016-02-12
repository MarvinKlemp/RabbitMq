<?php

namespace Infrastructure\Queue\RabbitMq\Producer;

use Infrastructure\Queue\Messages\RequestInfoMessage;
use Infrastructure\Queue\Producer\RequestInfoProducerInterface;
use Infrastructure\Queue\RabbitMq\MessageTransformer\RequestInfoMessageTransformer;
use Infrastructure\Queue\RabbitMq\Publisher;

class RequestInfoProducer implements RequestInfoProducerInterface
{
    /**
     * @var RequestInfoMessageTransformer
     */
    private $transformer;
    /**
     * @var Publisher
     */
    private $publisher;

    /**
     * @param RequestInfoMessageTransformer $transformer
     * @param Publisher $publisher
     */
    public function __construct(RequestInfoMessageTransformer $transformer, Publisher $publisher)
    {
        $this->transformer = $transformer;
        $this->publisher = $publisher;
    }

    public function produce(RequestInfoMessage $message)
    {
        $this->publisher->publish(
            $this->transformer->reverseTransform($message)
        );
    }
}
