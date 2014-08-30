<?php

namespace FXL\Component\Generator\Maze\Component;

use FXL\Component\Generator\Maze\Component\Base;

class Wall extends Base
{
    CONST id = 1;
    protected $name = 'wall';

    public function isValid()
    {
        return true;
    }
}