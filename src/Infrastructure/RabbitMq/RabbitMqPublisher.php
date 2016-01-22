<?php

namespace Infrastructure\RabbitMq;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMqPublisher
{
    /**
     * @var AMQPStreamConnection
     */
    protected $connection;

    /**
     * @var AMQPChannel
     */
    protected $channel;

    /**
     * @var string
     */
    protected $exchangeName;

    /**
     * @param string $exchangeName
     */
    public function __construct($exchangeName = 'logs')
    {
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'password');
        $this->channel = $this->connection->channel();
        $this->exchangeName = $exchangeName;

        $this->channel->exchange_declare('logs', 'fanout', false, false, false);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
