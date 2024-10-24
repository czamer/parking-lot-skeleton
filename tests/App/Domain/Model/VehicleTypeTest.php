<?php

namespace App\Domain\Model;

use PHPUnit\Framework\TestCase;

class VehicleTypeTest extends TestCase
{

    public function testValidVehicleType(): void
    {
        $this->assertEquals('car', VehicleType::CAR->value);
        $this->assertEquals('motorcycle', VehicleType::MOTORCYCLE->value);
        $this->assertEquals('bus', VehicleType::BUS->value);
    }

    public function testSpotSize(): void
    {
        $this->assertEquals(1, VehicleType::CAR->getSpotSize());
        $this->assertEquals(0.5, VehicleType::MOTORCYCLE->getSpotSize());
        $this->assertEquals(2, VehicleType::BUS->getSpotSize());
    }
}
