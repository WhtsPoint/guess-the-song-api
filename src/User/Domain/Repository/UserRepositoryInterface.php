<?php

namespace App\User\Domain\Repository;

use App\User\Domain\Entity\User;
use App\User\Domain\Exception\UserNotFoundException;
use App\Utils\Domain\ValueObject\Uuid;

interface UserRepositoryInterface
{
    public function create(User $user): void;
    public function findUserById(Uuid $id): ?User;
    public function getUserByID(Uuid $id): User;
    public function isExistsWithUsername(string $username): bool;
        /**
     * @throws UserNotFoundException
     */
    public function delete(User $user): void;
}