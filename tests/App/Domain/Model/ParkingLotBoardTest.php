<?php

namespace App\Domain\Model;

use PHPUnit\Framework\TestCase;

class ParkingLotBoardTest extends TestCase
{
    public function testGetFreeSpots(): void
    {
        $floor1 = new ParkingLotFloor(10, 5, 2);
        $floor2 = new ParkingLotFloor(8, 3, 1);
        $board = new ParkingLotBoard($floor1, $floor2);

        $this->assertEquals(18, $board->getFreeSpots(VehicleType::CAR));
        $this->assertEquals(8, $board->getFreeSpots(VehicleType::MOTORCYCLE));
        $this->assertEquals(3, $board->getFreeSpots(VehicleType::BUS));
    }

    public function testAllocateSpot(): void
    {
        $floor1 = new ParkingLotFloor(1, 0, 0);
        $floor2 = new ParkingLotFloor(1, 1, 1);
        $board = new ParkingLotBoard($floor1, $floor2);

        $board->allocateSpot(VehicleType::CAR);
        $this->assertEquals(0, $floor1->getFreeSpots(VehicleType::CAR));
        $this->assertEquals(1, $floor2->getFreeSpots(VehicleType::CAR));

        $board->allocateSpot(VehicleType::CAR);
        $this->assertEquals(0, $floor2->getFreeSpots(VehicleType::CAR));

        $board->allocateSpot(VehicleType::MOTORCYCLE);
        $this->assertEquals(0, $floor2->getFreeSpots(VehicleType::MOTORCYCLE));

        $board->allocateSpot(VehicleType::BUS);
        $this->assertEquals(0, $floor2->getFreeSpots(VehicleType::BUS));
    }

    public function testAllocateSpotThrowsExceptionWhenNoSpotsAvailable(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No available spots for car');

        $floor1 = new ParkingLotFloor(0, 0, 0);
        $floor2 = new ParkingLotFloor(0, 0, 0);
        $board = new ParkingLotBoard($floor1, $floor2);

        $board->allocateSpot(VehicleType::CAR);
    }

}
