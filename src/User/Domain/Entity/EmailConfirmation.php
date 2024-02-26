<?php

namespace App\User\Domain\Entity;

use App\User\Domain\Exception\EmailAlreadyConfirmedException;
use App\User\Domain\Exception\EmailConfirmationCodeExpired;
use App\User\Domain\Exception\InvalidConfirmationCodeException;
use App\Utils\Domain\ValueObject\Email;
use DateTimeImmutable;

class EmailConfirmation
{
    public const CODE_LENGTH = 4;
    public const CODE_LIFETIME = '1 hour';
    private string $code;
    private DateTimeImmutable $expiredAt;

    public function __construct(
        private ?Email $email = null,
        private bool $isConfirmed = false
    ) {
        $this->expiredAt = new DateTimeImmutable(self::CODE_LIFETIME);
        $this->code = bin2hex(random_bytes(self::CODE_LENGTH));
    }

    /**
     * @throws EmailAlreadyConfirmedException
     * @throws InvalidConfirmationCodeException
     */
    public function confirm(string $code): self
    {
        if ($this->isConfirmed === true) {
            throw new EmailAlreadyConfirmedException();
        }

        if ($this->expiredAt < new DateTimeImmutable()) {
            throw new EmailConfirmationCodeExpired();
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

    public function getEmail(): ?Email
    {
        return $this->email;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getExpiredAt(): DateTimeImmutable
    {
        return $this->expiredAt;
    }
}