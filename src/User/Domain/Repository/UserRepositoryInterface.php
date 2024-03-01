<?php

namespace App\User\Domain\Repository;

use App\User\Domain\Entity\User;
use App\User\Domain\Exception\UserNotFoundException;
use App\User\Domain\Representation\PublicUserData;
use App\Utils\Domain\ValueObject\Uuid;

interface UserRepositoryInterface
{
    public function create(User $user): void;
    public function findById(Uuid $id): ?User;
    /**
     * @throws UserNotFoundException
     */
    public function getById(Uuid $id): User;
    public function isExistsWithUsername(string $username): bool;
    public function delete(User $user): void;
    /**
     * @throws UserNotFoundException
     */
    public function getPublicDataById(Uuid $id): PublicUserData;
    /**
     * @throws UserNotFoundException
     */
    public function getByUsername(string $username): User;
}