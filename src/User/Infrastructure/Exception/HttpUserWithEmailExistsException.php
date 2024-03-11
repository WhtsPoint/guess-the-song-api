<?php

namespace App\User\Infrastructure\Exception;

use App\Utils\Infrastructure\Exception\InfrastructureExceptionInterface;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class HttpUserWithEmailExistsException extends ConflictHttpException implements InfrastructureExceptionInterface
{
    public function __construct()
    {
        parent::__construct('User with this email already exists', code: 1002);
    }
}