<?php

namespace App\User\Infrastructure\Exception;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class HttpInvalidCredentialsException extends UnauthorizedHttpException
{
    public function __construct()
    {
        parent::__construct('', 'Invalid user credentials', code: 1100);
    }

}