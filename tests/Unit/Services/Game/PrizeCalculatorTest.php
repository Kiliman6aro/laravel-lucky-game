<?php

namespace Tests\Unit\Services\Game;

use App\Services\Game\PrizeCalculator;
use App\ValueObjects\GameResult;
use PHPUnit\Framework\TestCase;

class PrizeCalculatorTest extends TestCase
{
    private PrizeCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new PrizeCalculator();
    }

    public function testNoPrizeForLose(): void
    {
        $loseResult = new GameResult(43);

        $prize = $this->calculator->calculate($loseResult);

        $this->assertEquals(0.0, $prize, 'Prize should be 0 for Lose status');
    }

    public function testPrizeForNumberOver900(): void
    {
        $winResult = new GameResult(950);

        $prize = $this->calculator->calculate($winResult);

        $this->assertEquals(665, $prize, 'Prize for number > 950 should be 70%');
        $this->assertIsFloat($prize, 'Prize should be a float');
    }

    public function testPrizeForNumberBetween600And900(): void
    {
        $winResult = new GameResult(700);

        $prize = $this->calculator->calculate($winResult);

        $this->assertEquals(350, $prize, 'Prize for number between 600 and 900 should be 50%');
    }

    public function testPrizeForNumberBetween300And600(): void
    {
        $winResult = new GameResult(400);

        $prize = $this->calculator->calculate($winResult);

        $this->assertEquals(120, $prize, 'Prize for number between 300 and 600 should be 30%');
    }

    public function testPrizeForNumberUpTo300(): void
    {
        $winResult = new GameResult(200);

        $prize = $this->calculator->calculate($winResult);

        $this->assertEquals(20, $prize, 'Prize for number <= 300 should be 10%');
    }

    public function testPrizeForNumberOver42(): void
    {
        $winResult = new GameResult(42);

        $prize = $this->calculator->calculate($winResult);

        $this->assertEquals(4.2, $prize, 'Prize for number <= 300 should be 10%');
        $this->assertIsFloat($prize, 'Prize should be a float');
    }
}
