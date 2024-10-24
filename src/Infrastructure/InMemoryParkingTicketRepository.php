<?php

declare(strict_types=1);

namespace App\Infrastructure;

namespace App\Infrastructure;

use App\Domain\Model\ParkingTicket;
use App\Domain\ParkingTicketRepositoryInterface;

class InMemoryParkingTicketRepository implements ParkingTicketRepositoryInterface
{
    /**
     * @phpstan-ignore-next-line
     *
     * @var array<int,ParkingTicket>
     */
    private array $tickets = [];

    public function save(ParkingTicket $ticket): void
    {
        $this->tickets[$ticket->getId()] = $ticket;
    }
}
