<?php

namespace App\User\Domain\Representation;

use App\User\Domain\Type\Role;

class AccessTokenUserData
{
    public function __construct(
        private string $id,
        /** @var Role[] */
        private array $roles,
        private bool $isEmailConfirmed
    ) {}

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function isEmailConfirmed(): bool
    {
        return $this->isEmailConfirmed;
    }

    public function getId(): string
    {
        return $this->id;
    }
}