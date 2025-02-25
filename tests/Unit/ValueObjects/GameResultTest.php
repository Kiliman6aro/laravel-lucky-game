<?php

namespace Tests\Unit\ValueObjects;

use App\ValueObjects\GameResult;
use PHPUnit\Framework\TestCase;

class GameResultTest extends TestCase
{

    public function testCanCreateGameResultFromNumber(): void
    {
        $number = 42;
        $result = new GameResult($number);

        $this->assertInstanceOf(GameResult::class, $result);
        $this->assertEquals(42, $result->getNumber());
        $this->assertEquals('Win', $result->getStatus());
    }

    public function testLoseForOddNumber(): void
    {
        $number = 43;
        $result = new GameResult($number);

        $this->assertInstanceOf(GameResult::class, $result);
        $this->assertEquals(43, $result->getNumber());
        $this->assertEquals('Lose', $result->getStatus());
    }

    public function testMultipleWinCases(): void
    {
        $winNumbers = [2, 100, 600, 900];
        foreach ($winNumbers as $number) {
            $result = new GameResult($number);
            $this->assertEquals('Win', $result->getStatus(), "Number $number should be Win");
            $this->assertEquals($number, $result->getNumber());
        }
    }

    public function testMultipleLoseCases(): void
    {
        $loseNumbers = [1, 101, 601, 901];
        foreach ($loseNumbers as $number) {
            $result = new GameResult($number);
            $this->assertEquals('Lose', $result->getStatus(), "Number $number should be Lose");
            $this->assertEquals($number, $result->getNumber());
        }
    }

    public function testBoundaryValues(): void
    {
        $boundaryWins = [300, 600, 900];
        $boundaryLoses = [301, 601, 901];

        foreach ($boundaryWins as $number) {
            $result = new GameResult($number);
            $this->assertEquals('Win', $result->getStatus(), "Number $number should be Win");
        }

        foreach ($boundaryLoses as $number) {
            $result = new GameResult($number);
            $this->assertEquals('Lose', $result->getStatus(), "Number $number should be Lose");
        }
    }

    public function testImmutability(): void
    {
        $number = 42;
        $result = new GameResult($number);


        $this->assertEquals(42, $result->getNumber());
        $this->assertEquals('Win', $result->getStatus());


        $newResult = new GameResult($number);
        $this->assertEquals($result->getNumber(), $newResult->getNumber());
        $this->assertEquals($result->getStatus(), $newResult->getStatus());
        $this->assertNotSame($result, $newResult);
    }
}
