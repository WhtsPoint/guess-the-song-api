<?php

namespace App\Utils\Infrastructure\Validation\Mapper;

interface ClassMapperInterface
{
    public function denormalizeClass(array $arguments, string $classname);
    public function getErrors();
}