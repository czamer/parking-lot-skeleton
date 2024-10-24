<?php

declare(strict_types=1);

namespace App\Domain\Model;

final class ParkingTicket
{
    private string $id;
    private VehicleType $vehicleType;
    private \DateTimeImmutable $startTime;
    private float $toPay;

    public function __construct(string $id, VehicleType $vehicleType, \DateTimeImmutable $startTime, float $toPay)
    {
        $this->id = $id;
        $this->vehicleType = $vehicleType;
        $this->startTime = $startTime;
        $this->toPay = $toPay;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getVehicleType(): VehicleType
    {
        return $this->vehicleType;
    }

    public function getStartTime(): \DateTimeImmutable
    {
        return $this->startTime;
    }

    public function getToPay(): float
    {
        return $this->toPay;
    }
}
