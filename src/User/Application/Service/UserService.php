<?php

namespace App\User\Application\Service;

use App\User\Application\Dto\UserCreationDto;
use App\User\Application\Dto\UserCreationResultDto;
use App\User\Domain\Entity\User;
use App\User\Domain\Exception\UserNotFoundException;
use App\User\Domain\Exception\UserWithEmailExistsException;
use App\User\Domain\Exception\UserWithUsernameExistsException;
use App\User\Domain\Factory\UserFactory;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Utils\Application\Service\BaseService;
use App\Utils\Domain\Repository\FlusherInterface;
use App\Utils\Domain\ValueObject\Uuid;

class UserService extends BaseService
{
    public function __construct(
        private UserFactory $factory,
        private UserRepositoryInterface $repository,
        private FlusherInterface $flusher
    ) {}

    /**
     * @throws UserWithUsernameExistsException
     * @throws UserWithEmailExistsException
     */
    public function create(UserCreationDto $dto): User
    {
        if ($this->repository->isExistsWithUsername($dto->username)) {
            throw new UserWithUsernameExistsException();
        }

        if ($this->repository->isExistsWithEmail($dto->email)) {
            throw new UserWithEmailExistsException();
        }

        $user = $this->factory->create(
            $dto->username,
            $dto->password,
            $dto->email
        );

        $this->repository->create($user);

        return $user;
    }

    /**
     * @throws UserWithUsernameExistsException
     * @throws UserWithEmailExistsException
     */
    public function createAndCommit(UserCreationDto $dto): UserCreationResultDto
    {
        $user = $this->create($dto);
        $this->flusher->flush();

        return new UserCreationResultDto($user->getId());
    }

    /**
     * @throws UserNotFoundException
     */
    public function deleteById(Uuid $id): void
    {
        $user = $this->repository->getById($id);
        $this->repository->delete($user);
        $this->flusher->flush();
    }
}