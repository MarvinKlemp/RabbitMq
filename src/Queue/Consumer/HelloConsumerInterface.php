<?php

namespace Queue\Consumer;

use Queue\HelloMessage;

interface HelloConsumerInterface
{
    /**
     * @param HelloMessage $message
     * @throws ConsumingException
     */
    public function consume(HelloMessage $message);
}
