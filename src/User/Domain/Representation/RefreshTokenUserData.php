<?php

namespace App\User\Domain\Representation;

class RefreshTokenUserData
{
    public function __construct(
        private string $id
    ) {}

    public function getId(): string
    {
        return $this->id;
    }
}