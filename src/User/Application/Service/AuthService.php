<?php

namespace App\User\Application\Service;

use App\User\Application\Dto\LoginCredentialsDto;
use App\User\Application\Exception\InvalidCredentialsException;
use App\User\Domain\Exception\InvalidJWTException;
use App\User\Domain\Exception\TokenExpiredException;
use App\User\Domain\Exception\UserNotFoundException;
use App\User\Domain\Helper\JWTInterface;
use App\User\Domain\Helper\PasswordHasherInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\ValueObject\Tokens;
use App\Utils\Domain\ValueObject\Uuid;

class AuthService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private JWTInterface $JWT,
        private PasswordHasherInterface $passwordHasher
    ) {}

    /**
     * @throws UserNotFoundException
     * @throws InvalidCredentialsException
     */
    public function login(LoginCredentialsDto $dto): Tokens
    {
        $user = $this->userRepository->getByUsername($dto->username);

        if ($user->isPasswordValid($dto->password, $this->passwordHasher) === false) {
            throw new InvalidCredentialsException();
        }

        return $this->JWT->generate($user->getId(), $user->getRoles(), $user->isConfirmed());
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidJWTException
     * @throws TokenExpiredException
     */
    public function refresh(string $refreshToken): Tokens {
        $userData = $this->JWT->decodeRefresh($refreshToken);
        $user = $this->userRepository->getById(new Uuid($userData->getId()));

        return new Tokens(
            $this->JWT->generateAccess($user->getId(), $user->getRoles(), $user->isConfirmed()),
            $refreshToken
        );
    }
}