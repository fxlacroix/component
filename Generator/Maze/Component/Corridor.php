<?php

namespace FXL\Component\Generator\Maze\Component;

use FXL\Component\Generator\Maze\Component\Base;

class Corridor extends Base
{
    CONST id = 1;
    protected $name = 'corridor';

    public function isValid()
    {
        return true;
    }
}