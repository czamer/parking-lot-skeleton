<?php

namespace App\Domain\Model;

enum VehicleType: string
{
    case MOTORCYCLE = 'motorcycle';
    case CAR = 'car';
    case BUS = 'bus';

    public static function fromString(string $type): self
    {
        return match ($type) {
            'motorcycle' => self::MOTORCYCLE,
            'car' => self::CAR,
            'bus' => self::BUS,
            default => throw new \InvalidArgumentException('Invalid vehicle type'),
        };
    }

    public function getSpotSize(): float
    {
        return match ($this) {
            self::MOTORCYCLE => 0.5,
            self::CAR => 1,
            self::BUS => 2,
        };
    }
}
