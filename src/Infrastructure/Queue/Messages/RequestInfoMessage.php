<?php

namespace Infrastructure\Queue\Messages;

class RequestInfoMessage extends BaseMessage
{
    const TYPE = 'request_info';

    /**
     * @var string
     */
    private $message;

    /**
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;

        parent::__construct(static::TYPE);
    }

    public function toString()
    {
    }
}
