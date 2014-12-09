<?php
/**
 * Created by PhpStorm.
 * User: grt
 * Date: 14-10-28
 * Time: 19:11
 */

namespace Webtaxi\MainBundle;



use InvalidArgumentException;

class Calculator
{
    public function add($x, $y)
    {
        return $x + $y;
    }

    public function division($x, $y)
    {
        if ($y == 0) {
            throw new InvalidArgumentException('Cannot divide from 0');
        }

        return $x / $y;
    }
} 