<?php

declare(strict_types=1);

namespace App\Domain\Model;

final class ParkingLotBoard
{
    /**
     * @var ParkingLotFloor[]
     */
    private array $floors;

    public function __construct(ParkingLotFloor ...$floors)
    {
        $this->floors = $floors;
    }

    /**
     * @return ParkingLotFloor[]
     */
    public function getFloors(): array
    {
        return $this->floors;
    }

    public function getFreeSpots(VehicleType $vehicleType): int
    {
        $freeSpots = 0;
        foreach ($this->floors as $floor) {
            $freeSpots += $floor->getFreeSpots($vehicleType);
        }

        return $freeSpots;
    }

    public function allocateSpot(VehicleType $vehicleType): void
    {
        foreach ($this->floors as $floor) {
            if ($floor->getFreeSpots($vehicleType) > 0) {
                $floor->allocateSpot($vehicleType);

                return;
            }
        }
        throw new \RuntimeException('No available spots for '.$vehicleType->value);
    }
}
