<?php

namespace App\Email\Infrastructure;

use App\Email\Application\Dto\EmailConfirmationDto;
use App\Email\Application\EmailService;
use App\Utils\Domain\ValueObject\Email;

class Api
{
    public function __construct(
        private EmailService $service
    ) {}

    public function onUserEmailConfirmationCodeChanged(string $email, string $code): void
    {
        $this->service->onUserEmailConfirmationCodeChanged(new EmailConfirmationDto(
            new Email($email),
            $code
        ));
    }
}