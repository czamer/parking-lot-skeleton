<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\VehicleType;

final readonly class CreateParkingTicketCommand
{
    public function __construct(private VehicleType $vehicleType)
    {
    }

    public function getVehicleType(): VehicleType
    {
        return $this->vehicleType;
    }
}
