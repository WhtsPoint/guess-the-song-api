<?php

namespace App\User\Application\Dto;

use App\Utils\Domain\ValueObject\Email;

class UserCreationDto
{
    public function __construct(
        public string $username,
        public string $password,
        public Email $email
    ) {}
}