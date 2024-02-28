<?php

namespace App\Utils\Infrastructure\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

class JsonErrorResponse extends JsonResponse
{
    public function __construct($message, string $statusCode, ?string $code = null)
    {
        parent::__construct(
            [...['message' => $message], ...($code ? ['code' => $code] : [])],
            $statusCode,
            ['Content-Type' => 'application/problem+json']
        );
    }
}