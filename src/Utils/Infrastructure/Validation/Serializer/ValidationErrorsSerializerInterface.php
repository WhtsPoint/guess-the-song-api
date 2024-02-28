<?php

namespace App\Utils\Infrastructure\Validation\Serializer;

use Symfony\Component\Validator\ConstraintViolationListInterface;

interface ValidationErrorsSerializerInterface
{
    public function convertErrorsForResponse(ConstraintViolationListInterface $errors): array;
}