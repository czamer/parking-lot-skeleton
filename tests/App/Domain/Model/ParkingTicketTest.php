<?php

namespace App\Domain\Model;

use PHPUnit\Framework\TestCase;

class ParkingTicketTest extends TestCase
{
    public function testParkingTicket(): void
    {
        $vehicleType = VehicleType::CAR;
        $startTime = new \DateTimeImmutable();
        $toPay = 10.0;
        $ticket = new ParkingTicket('1', $vehicleType, $startTime, $toPay);

        $this->assertEquals('1', $ticket->getId());
        $this->assertEquals($vehicleType, $ticket->getVehicleType());
        $this->assertEquals($startTime, $ticket->getStartTime());
        $this->assertEquals($toPay, $ticket->getToPay());

    }

}
