<?php

namespace App\Utils\Infrastructure\Validation\Data;

class TypeError
{
    public function __construct(
        private array $expectedTypes,
        private string $currentType,
        private string $fieldName
    ) {}

    public function getExpectedTypes(): array
    {
        return $this->expectedTypes;
    }

    public function getCurrentType(): string
    {
        return $this->currentType;
    }

    public function getFieldName(): string
    {
        return $this->fieldName;
    }
}