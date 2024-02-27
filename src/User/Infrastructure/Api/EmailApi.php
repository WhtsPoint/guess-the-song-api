<?php

namespace App\User\Infrastructure\Api;

use App\Email\Infrastructure\Api;

class EmailApi
{
    public function __construct(
        private Api $api
    ) {}

    public function onConfirmationCodeRefresh(string $email, string $code): void
    {
        $this->api->onUserEmailConfirmationCodeChanged($email, $code);
    }
}