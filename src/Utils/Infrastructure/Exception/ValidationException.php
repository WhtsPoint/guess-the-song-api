<?php

namespace App\Utils\Infrastructure\Exception;

use Exception;

class ValidationException extends Exception
{
    public function __construct(
        private array $errors,
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}