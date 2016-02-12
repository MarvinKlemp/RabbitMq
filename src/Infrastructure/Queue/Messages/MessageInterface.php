<?php

namespace Infrastructure\Queue\Messages;

interface MessageInterface
{
    /**
     * @return string
     */
    public function toString();
}
