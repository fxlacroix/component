<?php

namespace FXL\Component\Generator\Maze\Component;

abstract class Base
{
    public $x;
    public $y;

    function __toString()
    {
        return sprintf("<span class='%s %s-%s'>&nbsp;</span>", $this->name, $this->x, $this->y);
    }

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function isValid()
    {
        return false;
    }
}