<?php

namespace App\User\Domain\Exception;

use App\Utils\Domain\Exception\DomainExceptionInterface;
use Exception;

class InvalidConfirmationCodeException extends Exception implements DomainExceptionInterface {}