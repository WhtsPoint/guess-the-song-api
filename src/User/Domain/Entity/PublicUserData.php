<?php

namespace App\User\Domain\Entity;

use App\Utils\Domain\ValueObject\Email;
use App\Utils\Domain\ValueObject\Uuid;

class PublicUserData
{
    public function __construct(
        private Uuid $id,
        private string $username,
        private Email $email,
        private bool $isConfirmed
    ) {}

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function isConfirmed(): bool
    {
        return $this->isConfirmed;
    }
}