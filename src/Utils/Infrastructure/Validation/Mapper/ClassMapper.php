<?php

namespace App\Utils\Infrastructure\Validation\Mapper;

use App\Utils\Infrastructure\Validation\Data\TypeError;
use InvalidArgumentException;
use Symfony\Component\Serializer\Exception\PartialDenormalizationException;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ClassMapper implements ClassMapperInterface
{
    private array $errors = [];

    public function __construct(
        private DenormalizerInterface $serializer
    ) {}

    public function denormalizeClass(array $arguments, string $classname)
    {
        $this->errors = [];

        if (class_exists($classname) === false)  {
            throw new InvalidArgumentException('Argument type is invalid or class doesnt exists');
        }

        try {
            return $this->serializer->denormalize($arguments, $classname, context: [
                DenormalizerInterface::COLLECT_DENORMALIZATION_ERRORS => true,
                AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true
            ]);
        } catch (PartialDenormalizationException $exception) {
            foreach ($exception->getErrors() as $error) {
                $this->errors []= new TypeError(
                    $error->getExpectedTypes(),
                    $error->getCurrentType(),
                    $error->getPath()
                );
            }

            return null;
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}