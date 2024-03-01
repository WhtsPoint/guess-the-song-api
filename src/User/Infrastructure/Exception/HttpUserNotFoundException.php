<?php

namespace App\User\Infrastructure\Exception;

use App\Utils\Infrastructure\Exception\InfrastructureExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HttpUserNotFoundException extends NotFoundHttpException implements InfrastructureExceptionInterface {
    public function __construct()
    {
        parent::__construct('User not found', code: 1001);
    }
}