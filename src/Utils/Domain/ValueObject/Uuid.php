<?php

namespace App\Utils\Domain\ValueObject;

use InvalidArgumentException;
use Symfony\Component\Uid\Uuid as SymfonyUuid;
use Symfony\Component\Uid\UuidV4;

class Uuid
{
    private string $value;

    public function __construct(string $value)
    {
        if (SymfonyUuid::isValid($value) === false) {
            throw new InvalidArgumentException('Invalid uuid pattern');
        }

        $this->value = $value;
    }

    public static function create(): self {
        return new self((string) UuidV4::v4());
    }

    public function get(): string
    {
        return $this->value;
    }
}