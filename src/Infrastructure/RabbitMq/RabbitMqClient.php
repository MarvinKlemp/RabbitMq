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

    public function __construct($queueName = 'test', $channel = null)
    {
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'password');
        $this->channel = $this->connection->channel();
        $this->queueName = $queueName;
        $this->channel->queue_declare($this->queueName, false, true, false, false);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
