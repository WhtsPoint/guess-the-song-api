<?php

namespace App\User\Infrastructure\Repository;

use App\User\Domain\Entity\User;
use App\User\Domain\Exception\UserNotFoundException;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Utils\Domain\Repository\BaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        $this->repository = $this->entityManager->getRepository(User::class);
    }

    public function create(User $user): void
    {
        $this->entityManager->persist($user);
    }

    public function findUserById(string $id): ?User
    {
        return $this->repository->find(['id' => $id]);
    }

    /**
     * @throws UserNotFoundException
     */
    public function getUserByID(string $id): User
    {
        $user = $this->findUserById($id);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function delete(User $user): void
    {
        $this->entityManager->detach($user);
    }
}