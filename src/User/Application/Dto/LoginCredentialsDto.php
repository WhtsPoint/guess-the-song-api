<?php

namespace App\User\Application\Dto;

class LoginCredentialsDto
{
    public function __construct(
        public string $username,
        public string $password
    ) {}
}