<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Model\ParkingLotBoard;
use App\Domain\Model\ParkingLotFloor;
use App\Domain\Model\VehicleType;
use App\Domain\ParkingLotBoardRepositoryInterface;

class InMemoryParkingLotBoardRepository implements ParkingLotBoardRepositoryInterface
{
    private ParkingLotBoard $board;

    public function __construct()
    {
        $this->board = new ParkingLotBoard(...[
            new ParkingLotFloor(10, 5, 2),
            new ParkingLotFloor(8, 6, 1),
        ]);
    }

    public function getBoard(): ParkingLotBoard
    {
        return $this->board;
    }

    public function allocateSpot(VehicleType $vehicleType): void
    {
        foreach ($this->board->getFloors() as $floor) {
            if ($floor->getFreeSpots($vehicleType) > 0) {
                $floor->allocateSpot($vehicleType);

                return;
            }
        }
        throw new \RuntimeException('No available spots for '.$vehicleType->value);
    }
}
