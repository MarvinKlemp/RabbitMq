<?php

namespace Infrastructure\Queue\Consumer;

use Infrastructure\Queue\Messages\MessageInterface;

class RequestInfoConsumer implements ConsumerInterface
{
    public function consume(MessageInterface $message)
    {
    }
}
