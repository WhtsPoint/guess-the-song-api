<?php

namespace App\User\Domain\Exception;

use App\Utils\Domain\Exception\DomainExceptionInterface;
use Exception;

class EmailAlreadyConfirmedException extends Exception implements DomainExceptionInterface {}