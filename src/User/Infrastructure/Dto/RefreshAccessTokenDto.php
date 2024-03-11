<?php

namespace App\User\Infrastructure\Dto;

class RefreshAccessTokenDto
{
    public function __construct(
        public string $refreshToken
    ) {}
}