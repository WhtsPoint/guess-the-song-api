<?php

namespace App\User\Infrastructure\Exception;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class HttpUserWithUsernameExistsException extends ConflictHttpException
{
    public function __construct()
    {
        parent::__construct('User with this username already exists', code: 1000);
    }
}