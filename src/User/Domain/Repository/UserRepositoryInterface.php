<?php

namespace App\User\Domain\Repository;

use App\User\Domain\Entity\PublicUserData;
use App\User\Domain\Entity\User;
use App\User\Domain\Exception\UserNotFoundException;
use App\Utils\Domain\ValueObject\Uuid;

interface UserRepositoryInterface
{
    public function create(User $user): void;
    public function findUserById(Uuid $id): ?User;
    /**
     * @throws UserNotFoundException
     */
    public function getUserById(Uuid $id): User;
    public function isExistsWithUsername(string $username): bool;
    /**
     * @throws UserNotFoundException
     */
    public function delete(User $user): void;
    /**
     * @throws UserNotFoundException
     */
    public function getPublicDataById(Uuid $id): PublicUserData;
}