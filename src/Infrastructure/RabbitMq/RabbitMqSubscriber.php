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

    protected $queueName;

    protected $exchangeName;

    public function __construct($exchangeName = 'logs')
    {
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'password');
        $this->channel = $this->connection->channel();
        $this->exchangeName = $exchangeName;

        $this->channel->exchange_declare($exchangeName, 'fanout', false, false, false);

        list($queueName, ,) = $this->channel->queue_declare($this->queueName, false, false, true, false);
        $this->queueName = $queueName;
        $this->channel->queue_bind($this->queueName, $this->exchangeName);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
