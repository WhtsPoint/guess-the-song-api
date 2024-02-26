<?php

namespace App\User\Domain\Exception;

use App\Utils\Domain\Exception\DomainException;

class UserWithUsernameExists extends DomainException {}