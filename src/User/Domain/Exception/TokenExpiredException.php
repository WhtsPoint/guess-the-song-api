<?php

namespace App\User\Domain\Exception;

use App\Utils\Domain\Exception\DomainExceptionInterface;
use Exception;

class TokenExpiredException extends Exception implements DomainExceptionInterface {}