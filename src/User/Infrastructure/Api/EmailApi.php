<?php

namespace App\User\Infrastructure\Api;

use App\Email\Infrastructure\Api;
use App\User\Application\Api\EmailApiInterface;

class EmailApi implements EmailApiInterface
{
    public function __construct(
        private Api $api
    ) {}

    public function onConfirmationCodeRefresh(string $email, string $code): void
    {
        $this->api->onUserEmailConfirmationCodeChanged($email, $code);
    }
}