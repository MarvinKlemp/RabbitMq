<?php

namespace Infrastructure\Queue\Consumer;

use Infrastructure\Queue\Messages\MessageInterface;

interface ConsumerInterface
{
    /**
     * @param MessageInterface $message
     * @throws ConsumingException
     */
    public function consume(MessageInterface $message);
}
