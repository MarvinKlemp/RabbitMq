<?php

namespace Infrastructure\RabbitMq;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMqClient
{
    /**
     * @var AMQPStreamConnection
     */
    protected $connection;

    /**
     * @var \PhpAmqpLib\Channel\AMQPChannel
     */
    protected $channel;

    protected $queueName;

    protected $exchangeName;

    public function __construct($queueName = 'test', $exchangeName = 'logs', $channel = null)
    {
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'password');
        $this->channel = $this->connection->channel();
        $this->queueName = $queueName;
        $this->exchangeName = $exchangeName;

        $this->channel->queue_declare($this->queueName, false, true, false, false);
        $this->channel->exchange_declare('logs', 'fanout', false, false, false);
        $this->channel->queue_bind($this->queueName, $this->exchangeName);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
