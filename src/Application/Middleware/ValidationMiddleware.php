<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use League\OpenAPIValidation\PSR7\Exception\Validation\AddressValidationFailed;
use League\OpenAPIValidation\PSR7\ValidatorBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class ValidationMiddleware
{
    public function handle(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
        $validator = (new ValidatorBuilder())
            ->fromYamlFile('/app/openapi.yml')->getServerRequestValidator();

        $psrRequest = $psrHttpFactory->createRequest($request);
        try {
            $validator->validate($psrRequest);
        } catch (AddressValidationFailed $e) {
            $response = new JsonResponse(['errors' => $e->getVerboseMessage()], JsonResponse::HTTP_BAD_REQUEST);
            $event->setResponse($response);
        }
    }
}
