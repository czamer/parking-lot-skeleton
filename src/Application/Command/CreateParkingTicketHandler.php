<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\ParkingTicket;
use App\Domain\ParkingLotBoardRepositoryInterface;
use App\Domain\ParkingTicketRepositoryInterface;

readonly class CreateParkingTicketHandler
{
    public function __construct(
        private ParkingTicketRepositoryInterface $repository,
        private ParkingLotBoardRepositoryInterface $boardRepository
    ) {
    }

    /**
     * @return array<string, int|string|float>
     */
    public function handle(CreateParkingTicketCommand $command): array
    {
        $board = $this->boardRepository->getBoard();

        // Check if there are free spots
        if ($board->getFreeSpots($command->getVehicleType()) <= 0) {
            throw new \RuntimeException('No available spots for '.$command->getVehicleType()->value);
        }

        $ticket = new ParkingTicket(
            uniqid(),
            $command->getVehicleType(),
            new \DateTimeImmutable(),
            0.0
        );

        $this->repository->save($ticket);
        $this->boardRepository->allocateSpot($command->getVehicleType());

        return [
            'id' => $ticket->getId(),
            'start_time' => $ticket->getStartTime()->format('c'),
            'to_pay' => $ticket->getToPay(),
        ];
    }
}
