<?php

namespace Infrastructure\RabbitMq;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMqSubscriber
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
    protected $queueName;

    /**
     * @var string
     */
    protected $exchangeName;

    public function __construct($queueName, $exchangeName)
    {
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'password');
        $this->channel = $this->connection->channel();
        $this->exchangeName = $exchangeName;
        $this->queueName = $queueName;

        $this->channel->exchange_declare($exchangeName, 'fanout', false, false, false);
        $this->channel->queue_declare($this->queueName, false, true, false, false);
        $this->channel->queue_bind($this->queueName, $this->exchangeName);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
