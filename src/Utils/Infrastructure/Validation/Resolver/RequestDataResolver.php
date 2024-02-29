<?php

namespace App\Utils\Infrastructure\Validation\Resolver;

use App\Utils\Infrastructure\Exception\ValidationException;
use App\Utils\Infrastructure\Validation\Mapper\ClassMapperInterface;
use App\Utils\Infrastructure\Validation\Serializer\TypeErrorsSerializerInterface;
use App\Utils\Infrastructure\Validation\Serializer\ValidationErrorsSerializerInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDataResolver
{
    public function __construct(
        private ClassMapperInterface $classMapper,
        private ValidatorInterface $validator,
        private TypeErrorsSerializerInterface $typeErrorsSerializer,
        private ValidationErrorsSerializerInterface $validationErrorsSerializer
    ) {}

    /**
     * @throws ValidationException
     */
    public function resolve(array $data, ArgumentMetadata $argument): iterable
    {
        $mapped = $this->classMapper->denormalizeClass($data, $argument->getType());
        $errors = $this->classMapper->getErrors();

        if (count($errors) > 0 || $mapped === null) {
            throw new ValidationException(
                $this->typeErrorsSerializer->convertErrorsForResponse($data, $errors)
            );
        }

        $validationErrors = $this->validator->validate($mapped);

        if (count($validationErrors) > 0) {
            throw new ValidationException(
                $this->validationErrorsSerializer->convertErrorsForResponse($validationErrors)
            );
        }

        return [$mapped];
    }
}