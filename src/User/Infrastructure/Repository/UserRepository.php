<?php

namespace App\User\Infrastructure\Repository;

use App\User\Domain\Entity\User;
use App\User\Domain\Exception\UserNotFoundException;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\Representation\PublicUserData;
use App\Utils\Domain\Repository\BaseRepository;
use App\Utils\Domain\ValueObject\Email;
use App\Utils\Domain\ValueObject\Uuid;
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

    public function findById(Uuid $id): ?User
    {
        return $this->repository->find(new Uuid($id));
    }

    /**
     * @throws UserNotFoundException
     */
    public function getById(Uuid $id): User
    {
        $user = $this->findById($id);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
    }

    public function isExistsWithUsername(string $username): bool
    {
        return $this->repository->count(['username' => $username]) !== 0;
    }

    /**
     * @throws UserNotFoundException
     */
    public function getPublicDataById(Uuid $id): PublicUserData
    {
        $publicData = $this->entityManager
            ->createQuery(
                'SELECT NEW App\User\Domain\Entity\PublicUserData(u.id, u.username, u.emailConfirmation.email, u.emailConfirmation.isConfirmed)
                FROM App\User\Domain\Entity\User u
                WHERE u.id = :id'
            )->setParameter('id', $id)
            ->getOneOrNullResult();

        if ($publicData === null) {
            throw new UserNotFoundException();
        }

        return $publicData;
    }

    public function findByUsername(string $username): ?User
    {
        return $this->repository->findOneBy(['username' => $username]);
    }

    /**
     * @throws UserNotFoundException
     */
    public function getByUsername(string $username): User
    {
        $user = $this->findByUsername($username);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function isExistsWithEmail(Email $email): bool
    {
        return $this->repository->count(['emailConfirmation.email' => $email]) !== 0;
    }
}