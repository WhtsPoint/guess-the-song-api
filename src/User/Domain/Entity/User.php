<?php

namespace App\User\Domain\Entity;

use App\User\Domain\Bus\Events\OnEmailConfirmationRefreshed;
use App\User\Domain\Exception\EmailAlreadyConfirmedException;
use App\User\Domain\Exception\InvalidConfirmationCodeException;
use App\User\Domain\Helper\PasswordHasherInterface;
use App\User\Domain\Type\Role;
use App\Utils\Domain\Entity\RootAggregate;
use App\Utils\Domain\ValueObject\Email;
use App\Utils\Domain\ValueObject\Uuid;
use DateTimeImmutable;
use Exception;

class User extends RootAggregate
{
    private Uuid $id;
    private ?string $password = null;
    private ?EmailConfirmation $emailConfirmation = null;
    private array $roles = [];

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

    public function isPasswordValid(string $password, PasswordHasherInterface $hasher): bool
    {
        if ($this->password === null) return true;

        return $hasher->isValid($password, $this->password);
    }

    public function getEmail(): ?Email
    {
        return $this->emailConfirmation?->getEmail();
    }

    public function getConfirmationExpiredAt(): DateTimeImmutable
    {
        return $this->emailConfirmation?->getExpiredAt();
    }

    /**
     * @throws Exception
     */
    public function setEmail(?Email $email): void
    {
        if ($email === null) {
            $this->emailConfirmation = null;
            return;
        }

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
     */
    public function confirm(string $code): void
    {
        $this->emailConfirmation = $this->emailConfirmation->confirm($code);
    }

    private function sendEmailEvent(EmailConfirmation $confirmation): void {

        $this->pushEvent(new OnEmailConfirmationRefreshed(
            $confirmation->getEmail(),
            $confirmation->getCode()
        ));
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function addRole(Role $role): void
    {
    }
}