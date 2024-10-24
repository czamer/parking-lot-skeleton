<?php

declare(strict_types=1);

namespace App\UI\HTTP;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class HealthCheckController
{
    #[Route('/health', name: 'health_check', methods: ['GET'])]
    public function healthCheck(): JsonResponse
    {
        return new JsonResponse(null, JsonResponse::HTTP_OK);
    }
}
