<?php

namespace App\Utils\Infrastructure\Doctrine\Type;

use App\Utils\Domain\ValueObject\Uuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;

class UuidType extends StringType
{
    public const NAME = 'uuid';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value ? new Uuid($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Uuid ? $value->get() : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}