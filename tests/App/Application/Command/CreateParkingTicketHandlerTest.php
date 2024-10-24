<?php

namespace App\Application\Command;

use App\Domain\Model\VehicleType;
use App\Domain\ParkingLotBoardRepositoryInterface;
use App\Infrastructure\InMemoryParkingLotBoardRepository;
use PHPUnit\Framework\TestCase;
use App\Application\Command\CreateParkingTicketCommand;
use App\Application\Command\CreateParkingTicketHandler;
use App\Infrastructure\InMemoryParkingTicketRepository;

class CreateParkingTicketHandlerTest extends TestCase
{
    public function testHandle(): void
    {
        $repository = new InMemoryParkingTicketRepository();
        $boardRepository = new InMemoryParkingLotBoardRepository();
        $handler = new CreateParkingTicketHandler($repository, $boardRepository);
        $command = new CreateParkingTicketCommand(VehicleType::CAR);

        $response = $handler->handle($command);

        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('start_time', $response);
        $this->assertArrayHasKey('to_pay', $response);
        $this->assertIsString($response['id']);
        $this->assertIsString($response['start_time']);
        $this->assertIsFloat($response['to_pay']);
    }
}
