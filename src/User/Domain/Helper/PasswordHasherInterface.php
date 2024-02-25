<?php

namespace App\User\Domain\Helper;

interface PasswordHasherInterface
{
    public function hash(string $password): string;
    public function isValid(string $password, string $hash): bool;
}