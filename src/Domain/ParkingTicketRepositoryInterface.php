<?php

namespace App\Domain;

use App\Domain\Model\ParkingTicket;

interface ParkingTicketRepositoryInterface
{
    public function save(ParkingTicket $ticket): void;
}
