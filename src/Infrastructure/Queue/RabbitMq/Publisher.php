<?php

namespace Infrastructure\Queue\RabbitMq;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Publisher
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
    private $queueName;

    /**
     * @param AMQPStreamConnection $connection
     * @param string $queueName
     */
    public function __construct(AMQPStreamConnection $connection, $queueName)
    {
        $this->connection = $connection;
        $this->channel = $this->connection->channel();
        $this->queueName = $queueName;

        $this->channel->queue_declare($this->queueName, false, true, false, false);
    }

    /**
     * @param AMQPMessage $message
     */
    public function publish(AMQPMessage $message)
    {
        $this->channel->basic_publish(
            $message,
            '',
            $this->queueName
        );
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}