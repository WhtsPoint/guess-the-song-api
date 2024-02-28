<?php

namespace App\Utils\Infrastructure\Validation\Serializer;

use App\Utils\Infrastructure\Validation\Data\TypeError;

class TypeErrorsSerializer implements TypeErrorsSerializerInterface
{
    /**
     * @param TypeError[] $errors
     */
    public function convertErrorsForResponse(array $arguments, array $errors): array
    {
        $isUnknown = fn (array $types) => count($types) === 1 && $types[0] === 'unknown';

        return array_reduce(
            $errors,
            fn ($prev, $error) => [$error->getFieldName() =>
                    sprintf(
                        $isUnknown($error->getExpectedTypes()) ?
                            'Invalid value type' :
                            'Invalid value type, %s instead of %s',
                        gettype(@$arguments[$error->getFieldName()]),
                        implode(', ', $error->getExpectedTypes())
                    )
                ] + $prev,
            []
        );
    }
}