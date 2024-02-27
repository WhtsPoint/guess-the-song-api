<?php

namespace App\Email\Application\Dto;

use App\Utils\Domain\ValueObject\Email;

class EmailConfirmationDto
{
    public function __construct(
        public Email $email,
        public string $code
    ) {}
}