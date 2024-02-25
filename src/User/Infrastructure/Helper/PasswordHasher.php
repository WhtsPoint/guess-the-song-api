<?php

namespace App\User\Infrastructure\Helper;

use App\User\Domain\Helper\PasswordHasherInterface;

class PasswordHasher implements PasswordHasherInterface
{
    public function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function isValid(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}