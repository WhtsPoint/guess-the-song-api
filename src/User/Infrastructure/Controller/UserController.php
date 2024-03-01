<?php

namespace App\User\Infrastructure\Controller;

use App\User\Application\Dto\UserCreationDto;
use App\User\Application\Service\UserService;
use App\User\Domain\Exception\UserNotFoundException;
use App\User\Domain\Exception\UserWithUsernameExistsException;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Infrastructure\Dto\UserCreationDataDto;
use App\User\Infrastructure\Exception\HttpUserNotFoundException;
use App\User\Infrastructure\Exception\HttpUserWithUsernameExistsException;
use App\Utils\Domain\ValueObject\Email;
use App\Utils\Domain\ValueObject\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class UserController extends AbstractController
{
    public function __construct(
        private UserService $service,
        private UserRepositoryInterface $repository
    ) {}

    #[Route(path: '/api/user', methods: 'POST')]
    public function create(#[ValueResolver('map_request_payload')] UserCreationDataDto $dto): JsonResponse
    {
        try {
            $response = $this->service->createAndCommit(new UserCreationDto(
                $dto->username,
                $dto->password,
                new Email($dto->email)
            ));
        } catch (UserWithUsernameExistsException) {
            throw new HttpUserWithUsernameExistsException();
        }

        return $this->json($response);
    }

    #[Route(path: '/api/user/{id}', requirements: ['id' => Requirement::UUID_V4],  methods: 'GET')]
    public function getById(string $id): JsonResponse
    {
        try {
            $userData = $this->repository->getPublicDataById(new Uuid($id));

            return $this->json($userData);
        } catch (UserNotFoundException) {
            throw new HttpUserNotFoundException();
        }
    }
}