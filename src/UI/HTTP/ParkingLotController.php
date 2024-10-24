<?php

declare(strict_types=1);

namespace App\UI\HTTP;

use App\Application\Command\CreateParkingTicketCommand;
use App\Application\Command\CreateParkingTicketHandler;
use App\Domain\Model\VehicleType;
use App\Domain\ParkingLotBoardRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ParkingLotController
{
    private CreateParkingTicketHandler $createParkingTicketHandler;
    private ParkingLotBoardRepositoryInterface $boardRepository;

    public function __construct(
        CreateParkingTicketHandler $createParkingTicketHandler,
        ParkingLotBoardRepositoryInterface $boardRepository,
    ) {
        $this->createParkingTicketHandler = $createParkingTicketHandler;
        $this->boardRepository = $boardRepository;
    }

    #[Route('/parking_lot/ticket', methods: ['POST'])]
    public function createTicket(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $command = new CreateParkingTicketCommand(VehicleType::fromString($data['vehicle_type']));
        $response = $this->createParkingTicketHandler->handle($command);

        return (new JsonResponse())
            ->setEncodingOptions(JsonResponse::DEFAULT_ENCODING_OPTIONS |JSON_PRESERVE_ZERO_FRACTION)
            ->setData($response);
    }

    #[Route('/parking_lot/board', methods: ['GET'])]
    public function board(Request $request): JsonResponse
    {
        $board = $this->boardRepository->getBoard();
        $floors = [];

        foreach ($board->getFloors() as $floor) {
            $floors[] = [
                'cars' => $floor->getFreeSpots(VehicleType::CAR),
                'motorcycles' => $floor->getFreeSpots(VehicleType::MOTORCYCLE),
                'buses' => $floor->getFreeSpots(VehicleType::BUS),
            ];
        }

        return new JsonResponse(['floors' => $floors], JsonResponse::HTTP_OK);
    }
}
