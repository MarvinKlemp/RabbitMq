<?php

namespace Infrastructure\Queue\Producer;

use Infrastructure\Queue\Messages\RequestInfoMessage;

interface RequestInfoProducerInterface
{
    public function produce(RequestInfoMessage $message);
}
