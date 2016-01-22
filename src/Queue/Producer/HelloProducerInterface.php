<?php

namespace Queue\Producer;

use Queue\HelloMessage;

interface HelloProducerInterface
{
    public function produce(HelloMessage $message);
}
