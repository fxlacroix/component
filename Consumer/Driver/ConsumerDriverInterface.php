<?php

namespace FXL\Component\Consumer\Driver;

interface ConsumerDriverInterface
{
    public function search($term);

    public function find($id);
}
