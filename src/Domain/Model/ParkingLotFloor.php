<?php

declare(strict_types=1);

namespace App\Domain\Model;

class ParkingLotFloor
{
    private int $cars;
    private int $motorcycles;
    private int $buses;

    public function __construct(int $cars, int $motorcycles, int $buses)
    {
        $this->cars = $cars;
        $this->motorcycles = $motorcycles;
        $this->buses = $buses;
    }

    public function getFreeSpots(VehicleType $vehicleType): int
    {
        return match ($vehicleType) {
            VehicleType::MOTORCYCLE => $this->motorcycles,
            VehicleType::CAR => $this->cars,
            VehicleType::BUS => $this->buses,
        };
    }

    public function allocateSpot(VehicleType $vehicleType): void
    {
        match ($vehicleType) {
            VehicleType::CAR => $this->cars--,
            VehicleType::MOTORCYCLE => $this->motorcycles--,
            VehicleType::BUS => $this->buses--,
        };
    }
}
