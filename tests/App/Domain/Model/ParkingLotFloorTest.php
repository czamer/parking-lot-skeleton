<?php

namespace App\Domain\Model;

use PHPUnit\Framework\TestCase;

class ParkingLotFloorTest extends TestCase
{
    public function testGetFreeSpots(): void
    {
        $floor = new ParkingLotFloor(10, 5, 2);

        $this->assertEquals(10, $floor->getFreeSpots(VehicleType::CAR));
        $this->assertEquals(5, $floor->getFreeSpots(VehicleType::MOTORCYCLE));
        $this->assertEquals(2, $floor->getFreeSpots(VehicleType::BUS));
    }

    public function testAllocateSpot(): void
    {
        $floor = new ParkingLotFloor(10, 5, 2);

        $floor->allocateSpot(VehicleType::CAR);
        $this->assertEquals(9, $floor->getFreeSpots(VehicleType::CAR));

        $floor->allocateSpot(VehicleType::MOTORCYCLE);
        $this->assertEquals(4, $floor->getFreeSpots(VehicleType::MOTORCYCLE));

        $floor->allocateSpot(VehicleType::BUS);
        $this->assertEquals(1, $floor->getFreeSpots(VehicleType::BUS));
    }
}
