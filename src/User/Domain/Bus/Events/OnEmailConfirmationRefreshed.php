<?php

namespace App\User\Domain\Bus\Events;

use App\Utils\Domain\Bus\Events\DomainEvent;
use App\Utils\Domain\ValueObject\Email;

class OnEmailConfirmationRefreshed extends DomainEvent
{
    public function __construct(
        public Email $email,
        public string $code
    ) {}
}