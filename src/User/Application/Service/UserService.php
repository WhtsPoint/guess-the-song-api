<?php

namespace App\User\Application\Service;

use App\User\Application\Dto\UserCreationDto;
use App\User\Application\Dto\UserCreationResultDto;
use App\User\Domain\Entity\User;
use App\User\Domain\Factory\UserFactory;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Utils\Application\Service\BaseService;
use App\Utils\Domain\Repository\FlusherInterface;

class UserService extends BaseService
{
    public function __construct(
        private UserFactory $factory,
        private UserRepositoryInterface $repository,
        private FlusherInterface $flusher
    ) {}

    public function create(UserCreationDto $dto): User
    {
        $user = $this->factory->create(
            $dto->username,
            $dto->password
        );

        $this->repository->create($user);

        return $user;
    }

    public function createAndCommit(UserCreationDto $dto): UserCreationResultDto
    {
        $user = $this->create($dto);
        $this->flusher->flush();

        return new UserCreationResultDto($user->getId());
    }
}