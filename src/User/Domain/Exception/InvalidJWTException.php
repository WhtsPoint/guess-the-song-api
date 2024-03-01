<?php

namespace App\User\Domain\Exception;

use App\Utils\Domain\Exception\DomainExceptionInterface;
use Exception;

class InvalidJWTException extends Exception implements DomainExceptionInterface {}