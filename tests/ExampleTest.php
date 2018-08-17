<?php

//
//namespace Quiz\Tests;
//
//class ExampleTest extends \PHPUnit\Framework\TestCase
//{
//    public function testTrue()
//    {
//        self::assertTrue(true);
//    }
//}

namespace Quiz\Tests;

require_once 'tests/BowlingCalculator.php';

class BowlingCalculatorTest extends \PHPUnit\Framework\TestCase
{
    /** @var BowlingCalculator */
    private $calculator;

    public function setUp()
    {
        $this->calculator = new BowlingCalculator();
    }
    public function test_withNoHits_returnScore0()
    {

        for($i = 0 ; $i < 20 ; $i++){
            $this->calculator->throw(0);
        }
        $score = $this->calculator->getScore();
        $this->assertEquals(0,$score);
    }

    public function test_withSimpleThrows_calculateScore()
    {
        for($i = 0 ; $i < 20 ; $i++){
            $this->calculator->throw(1);
        }
        $score = $this->calculator->getScore();
        $this->assertEquals(20,$score);
    }

    public function test_withSpare_shouldAddPointsOfNextTwoThrows()
    {
        $this->calculator->throw(6);
        $this->calculator->throw(4);
        $this->calculator->throw(2);

        for ($i = 3; $i < 20; $i += 1) {
            $this->calculator->throw(1);
        }

        $score = $this->calculator->getScore();
        $this->assertEquals(33, $score);
    }

    public function test_withStrikeThrow_shouldAddEvenMorePoints()
    {
        $this->calculator->throw(10);
        $this->calculator->throw(5);
        $this->calculator->throw(2);

        for ($i = 4; $i < 20; $i += 1) {
            $this->calculator->throw(1);
        }

        $score = $this->calculator->getScore();
        $this->assertEquals(40, $score);
    }

}