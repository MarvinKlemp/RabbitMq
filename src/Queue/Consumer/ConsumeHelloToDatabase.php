<?php

namespace Queue\Consumer;

use Queue\HelloMessage;

class ConsumeHelloToDatabase implements HelloConsumerInterface
{
    /**
     * @param HelloMessage $message
     * @throws ConsumingException
     */
    public function consume(HelloMessage $message)
    {
        echo $message->body() . "\n";
    }
}
