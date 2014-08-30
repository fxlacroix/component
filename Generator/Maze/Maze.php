<?php

namespace FXL\Component\Generator\Maze;

use FXL\Component\Generator\Maze\Component\Border;
use FXL\Component\Generator\Maze\Component\Wall;
use FXL\Component\Generator\Maze\Component\Corridor;

class Maze
{
    public $x;
    public $y;
    public $map = array();

    public function __construct()
    {
        $this->x = 20;
        $this->y = 40;

        $this->initMap();
    }

    public function initMap()
    {

        // asshole model

        for ($_x = 0; $_x <= $this->x + 1; $_x++) {
            for ($_y = 0; $_y <= $this->y + 1; $_y++) {
                $this->map[$_x][$_y] = new Border($_x, $_y);
            }
        }

        for ($_x = 1; $_x <= $this->x; $_x++) {
            for ($_y = 1; $_y <= $this->y; $_y++) {
                $this->map[$_x][$_y] = new Wall($_x, $_y);
            }
        }

        for ($i = 0; $i < 10; $i++) {

            list($_x, $_y) = $this->getRandomPosition();

            $this->map[$_x][$_y] = new Corridor($_x, $_y);

            $this->createPath($_x, $_y);
        }
    }

    public function createPath($x, $y)
    {

        $validDirection = $this->getValidPosition($x, $y);

        while ($validDirection) {

            list($_x, $_y) = $validDirection;
            $this->map[$_x][$_y] = new Corridor($_x, $_y);

            $validDirection = $this->getValidPosition($_x, $_y);
        }
    }

    public function initPosition()
    {

    }

    public function initExit()
    {

    }

    public function completePath()
    {

    }

    public function checkCompletePath()
    {
        for ($_x = 1; $_x <= $this->x; $i++) {
            for ($_y = 1; $_y <= $this->x; $i++) {
                if ($visited == 0 && $this->map[$_x][$_y] == 0) {
                    return array($_x, $_y);
                }
                $visited = $this->map[$_x][$_y];
            }
        }
        return true;
    }

    public function findUncompleteSquare()
    {

    }

    public function findValidDirection()
    {


    }

    public function getValidPosition($x, $y)
    {
        list($_i, $_j) = $this->getRandomDirection();

        if (isset($this->map[$x + $_i][$y + $_j])
            && $this->map[$x + $_i][$y + $_j]->isValid()
        ) {

            return array($x + $_i, $y + $_j);
        }

        return false;
    }

    public function getRandomDirection($reset = false)
    {
        $directions = array(
            array(0, 1),
            array(1, 0),
            array(0, -1),
            array(-1, 0)
        );

        return array_shift($directions);
    }

    public function getRandomPosition()
    {
        $_x = rand(1, $this->x);
        $_y = rand(1, $this->y);

        return array($_x, $_y);
    }
}

function shuffle_assoc($list)
{
    if (!is_array($list)) return $list;

    $keys = array_keys($list);
    shuffle($keys);
    $random = array();
    foreach ($keys as $key)
        $random[$key] = $list[$key];

    return $random;
}
