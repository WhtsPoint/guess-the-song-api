<?php

namespace App\User\Application\Dto;

use App\Utils\Domain\ValueObject\Uuid;

class UserCreationResultDto
{
    public function __construct(
        public Uuid $id
    ) {}
}