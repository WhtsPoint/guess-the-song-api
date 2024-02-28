<?php

namespace App\Utils\Infrastructure\Validation\Serializer;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationErrorsSerializer implements ValidationErrorsSerializerInterface
{

    public function convertErrorsForResponse(ConstraintViolationListInterface $errors): array
    {
        $result = [];

        foreach ($errors as $error) {
            $prop = $error->getPropertyPath();
            $result[$prop] = [...(@$result[$prop] ?: []), $error->getMessage()];
        }

        return $result;
    }
}