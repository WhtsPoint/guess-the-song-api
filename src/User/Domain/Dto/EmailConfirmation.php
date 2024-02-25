<?php

namespace App\User\Domain\Dto;

use App\User\Domain\Exception\EmailAlreadyConfirmedException;
use App\User\Domain\Exception\InvalidConfirmationCodeException;
use App\Utils\Domain\ValueObject\Email;
use Exception;

class EmailConfirmation
{
    public const CODE_LENGTH = 4;
    private string $code;

    /**
     * @throws Exception
     */
    public function __construct(
        private Email $email,
        private bool $isConfirmed = false
    ) {
        $this->code = bin2hex(random_bytes(self::CODE_LENGTH));
    }

    /**
     * @throws EmailAlreadyConfirmedException
     * @throws InvalidConfirmationCodeException
     * @throws Exception
     */
    public function confirm(string $code): self
    {
        if ($this->isConfirmed === true) {
            throw new EmailAlreadyConfirmedException();
        }

        if ($this->code !== $code) {
            throw new InvalidConfirmationCodeException();
        }

        return new self($this->email, true);
    }

    public function isConfirmed(): bool
    {
        return $this->isConfirmed;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}