<?php

namespace App\User\Domain\Factory;

use App\User\Domain\Entity\User;
use App\User\Domain\Helper\PasswordHasherInterface;
use App\Utils\Domain\ValueObject\Email;

class UserFactory
{
    public function __construct(
        private PasswordHasherInterface $hasher
    ) {}

    public function create(
        string $username,
        ?string $password = null,
        ?Email $email = null
    ): User {
        $user = new User($username);

        if ($password !== null) {
            $user->setPassword($password, $this->hasher);
        }

        if ($email !== null) {
            $user->setEmail($email);
        }

        return $user;
    }
}