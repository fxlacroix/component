<?php

namespace FXL\Component\Consumer\Driver;

abstract class ConsumerDriver implements ConsumerDriverInterface
{
    public function search($term = null)
    {
        throw new \Exception('you must implement the search method !');
    }

    public function find($id = null)
    {
        throw new \Exception('you must implement the find method !');
    }
}
