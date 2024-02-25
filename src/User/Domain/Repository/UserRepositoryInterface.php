<?php

namespace App\User\Domain\Repository;

use App\User\Domain\Entity\User;
use App\User\Domain\Exception\UserNotFoundException;

interface UserRepositoryInterface
{
    public function create(User $user): void;
    public function findUserById(string $id): ?User;
    public function getUserByID(string $id): User;

    /**
     * @throws UserNotFoundException
     */
    public function delete(User $user): void;
}