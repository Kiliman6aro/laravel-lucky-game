<?php

namespace Tests\Unit\Services\Game;

use App\Services\Game\GameService;
use App\Services\Game\RandomNumberGenerator;
use App\ValueObjects\GameResult;
use Mockery;
use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testPlayReturnsGameResultWithExpectedNumber(): void
    {
        $mockGenerator = Mockery::mock(RandomNumberGenerator::class);
        $mockGenerator->shouldReceive('generate')
            ->once()
            ->with(1, 1000)
            ->andReturn(42);


        $gameService = new GameService($mockGenerator);
        $result = $gameService->play();

        $this->assertInstanceOf(GameResult::class, $result);
        $this->assertEquals(42, $result->getNumber(), 'The number should be the mocked value (42)');
        $this->assertEquals('Win', $result->getStatus(), 'Status should be Win for even number 42');
    }

    public function testPlayReturnsDifferentNumbers(): void
    {
        $testNumbers = [1, 42, 1000];

        foreach ($testNumbers as $number) {
            $mockGenerator = Mockery::mock(RandomNumberGenerator::class);
            $mockGenerator->shouldReceive('generate')
                ->once()
                ->with(1, 1000)
                ->andReturn($number);

            $gameService = new GameService($mockGenerator);
            $result = $gameService->play();

            $this->assertInstanceOf(GameResult::class, $result);
            $this->assertEquals($number, $result->getNumber(), "Number should be $number");
            $this->assertEquals($number % 2 === 0 ? 'Win' : 'Lose', $result->getStatus(), "Status should be " . ($number % 2 === 0 ? 'Win' : 'Lose') . " for $number");
        }
    }
}
