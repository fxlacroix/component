<?php

namespace FXL\Component\Generator\Maze\Component;

use FXL\Component\Generator\Maze\Component\Base;

class Border extends Base
{
    CONST id = 0;
    protected $name = 'border';

    public function isValid()
    {
        return false;
    }
}