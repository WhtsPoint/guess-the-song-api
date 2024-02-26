<?php

namespace App\User\Infrastructure\Api;

class EmailApi
{
    public function onConfirmationCodeRefresh(string $email, string $code): void
    {
    }
}