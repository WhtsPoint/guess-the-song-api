<?php

namespace App\Utils\Domain\ValueObject;

class Email implements ValueObjectInterface
{
    public const REGEX = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    private string $value;

    public function __construct(string $value)
    {
        if (@preg_match(self::REGEX, $value) === false) {
            throw new \InvalidArgumentException('Invalid email');
        }

        $this->value = $value;
    }

    public function get(): string
    {
        return $this->value;
    }
}