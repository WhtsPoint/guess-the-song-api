<?php

namespace App\User\Application\Api;

interface EmailApiInterface
{
    public function onConfirmationCodeRefresh(string $email, string $code): void;
}