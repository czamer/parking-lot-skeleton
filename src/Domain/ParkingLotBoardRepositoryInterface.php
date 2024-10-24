<?php

namespace App\Domain;

use App\Domain\Model\ParkingLotBoard;
use App\Domain\Model\VehicleType;

interface ParkingLotBoardRepositoryInterface
{
    public function getBoard(): ParkingLotBoard;

    public function allocateSpot(VehicleType $vehicleType): void;
}
