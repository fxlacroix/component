<?php
namespace FXL\Component\Consumer;

use FXL\Component\Consumer\Driver\ConsumerDriverInterface;

class Consumer
{
    private $consumer;

    public function __construct(ConsumerDriverInterface $consumer)
    {

        $this->consumer = $consumer;

    }

    public function search($term)
    {

        return $this->getConsumer()->search($term);
    }


    public function find($term)
    {

        return $this->getConsumer()->find($term);
    }

    public function getConsumer()
    {

        return $this->consumer;
    }
}
