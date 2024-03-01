<?php

namespace App\User\Application\Exception;

use App\Utils\Application\Exception\ApplicationExceptionInterface;
use Exception;

class InvalidCredentialsException extends Exception implements ApplicationExceptionInterface {}