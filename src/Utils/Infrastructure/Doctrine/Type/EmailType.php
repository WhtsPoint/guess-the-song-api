<?php

namespace App\Utils\Infrastructure\Doctrine\Type;

use App\Utils\Domain\ValueObject\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class EmailType extends StringType
{
    public const NAME = 'email';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value ? new Email($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Email ? $value->get() : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}