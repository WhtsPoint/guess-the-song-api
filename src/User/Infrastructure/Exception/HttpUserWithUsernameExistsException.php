<?php

namespace App\User\Infrastructure\Exception;

use App\Utils\Infrastructure\Exception\InfrastructureExceptionInterface;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class HttpUserWithUsernameExistsException extends ConflictHttpException implements InfrastructureExceptionInterface
{
    public function __construct()
    {
        parent::__construct('User with this username already exists', code: 1000);
    }
}