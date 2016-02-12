<?php

namespace Infrastructure\Queue\RabbitMq;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class Subscriber
{
    /**
     * @var Processor
     */
    private $processor;

    /**
     * @param Processor $processor
     * @param AMQPStreamConnection $connection
     * @param string $queueName
     */
    public function __construct(Processor $processor, AMQPStreamConnection $connection, $queueName)
    {
        $this->processor = $processor;
        $this->connection = $connection;
        $this->channel = $this->connection->channel();
        $this->queueName = $queueName;

        $this->channel->queue_declare($this->queueName, false, true, false, false);
    }

    /**
     * This methods block the thread
     */
    public function run()
    {
        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume($this->queueName, '', false, false, false, false, [$this->processor, 'process']);

        while(count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
