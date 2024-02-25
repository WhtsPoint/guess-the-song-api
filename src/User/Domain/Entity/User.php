<?php

namespace App\User\Domain\Entity;

use App\User\Domain\Helper\PasswordHasherInterface;
use App\User\Domain\Dto\EmailConfirmation;
use App\User\Domain\Events\OnEmailConfirmationRefreshed;
use App\User\Domain\Exception\EmailAlreadyConfirmedException;
use App\User\Domain\Exception\InvalidConfirmationCodeException;
use App\Utils\Domain\Entity\RootAggregate;
use App\Utils\Domain\ValueObject\Email;
use App\Utils\Domain\ValueObject\Uuid;
use Exception;
use InvalidArgumentException;

class User extends RootAggregate
{
    private Uuid $id;
    private ?string $password = null;
    private ?EmailConfirmation $emailConfirmation = null;

    public function __construct(
        private string $username
    ) {
        $this->id = Uuid::create();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setPassword(string $password, PasswordHasherInterface $hasher): void
    {
        $this->password = $hasher->hash($password);
    }

    public function isPasswordValid(string $hash, PasswordHasherInterface $hasher): bool
    {
        if ($this->password === null) return true;

        return $hasher->isValid($this->password, $hash);
    }

    public function getEmail(): ?Email
    {
        return $this->emailConfirmation?->getEmail();
    }

    /**
     * @throws Exception
     */
    public function setEmail(Email $email): void
    {
        $this->emailConfirmation = new EmailConfirmation(
            $email,
            false
        );
        $this->sendEmailEvent($this->emailConfirmation);
    }

    public function isConfirmed(): bool
    {
        if ($this->emailConfirmation === null) {
            return true;
        }

        return $this->emailConfirmation->isConfirmed();
    }

    /**
     * @throws EmailAlreadyConfirmedException
     * @throws InvalidConfirmationCodeException
     * @throws Exception
     */
    public function confirm(string $code): void
    {
        try {
            $this->emailConfirmation = $this->emailConfirmation->confirm($code);
        } catch (EmailAlreadyConfirmedException|InvalidArgumentException $exception) {
            $this->sendEmailEvent($this->emailConfirmation);
            throw $exception;
        }
    }

    private function sendEmailEvent(EmailConfirmation $confirmation): void {

        $this->pushEvent(new OnEmailConfirmationRefreshed(
            $confirmation->getEmail(),
            $confirmation->getCode()
        ));
    }
}