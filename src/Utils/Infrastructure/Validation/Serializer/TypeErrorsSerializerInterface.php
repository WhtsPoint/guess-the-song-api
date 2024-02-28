<?php

namespace App\Utils\Infrastructure\Validation\Serializer;

use App\Utils\Infrastructure\Validation\Data\TypeError;

interface TypeErrorsSerializerInterface
{
    /**
     * @param TypeError[] $errors
     */
    public function convertErrorsForResponse(array $arguments, array $errors);
}