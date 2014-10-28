<?php
/**
 * Created by PhpStorm.
 * User: grt
 * Date: 14-10-28
 * Time: 19:12
 */

namespace Webtaxi\MainBundle\Tests;


use InvalidArgumentException;
use Webtaxi\MainBundle\Calculator;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProvideAdd
     */
    public function testAdd($x, $y, $expected)
    {
        $calculator = new Calculator();

        $actual = $calculator->add($x, $y);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider dataProvideDivision
     */
    public function testDivision($x, $y, $expected)
    {
        $calculator = new Calculator();

        $actual = $calculator->division($x, $y);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testDivisionFromZero()
    {
        $calculator = new Calculator();

        $calculator->division(1, 0);
    }

    public function dataProvideAdd()
    {
        return array(
            array(1, 2, 3),
            array(10, 10, 20)
        );
    }

    public function dataProvideDivision()
    {
        return array(
            array(1, 1, 1),
            array(4, 2, 2)
        );
    }
} 