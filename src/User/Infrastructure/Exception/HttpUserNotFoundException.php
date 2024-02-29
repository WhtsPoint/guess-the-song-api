<?php

namespace App\User\Infrastructure\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HttpUserNotFoundException extends NotFoundHttpException {
    public function __construct()
    {
        parent::__construct('User not found', code: 1001);
    }
}