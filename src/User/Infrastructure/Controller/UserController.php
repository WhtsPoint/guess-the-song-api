<?php

namespace App\User\Infrastructure\Controller;

use App\User\Application\Dto\UserCreationDto;
use App\User\Application\Service\UserService;
use App\User\Domain\Exception\UserNotFoundException;
use App\User\Domain\Exception\UserWithEmailExistsException;
use App\User\Domain\Exception\UserWithUsernameExistsException;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\Representation\AccessTokenUserData;
use App\User\Domain\Type\Role;
use App\User\Infrastructure\Dto\UserCreationDataDto;
use App\User\Infrastructure\Exception\HttpUserNotFoundException;
use App\User\Infrastructure\Exception\HttpUserWithEmailExistsException;
use App\User\Infrastructure\Exception\HttpUserWithUsernameExistsException;
use App\User\Infrastructure\Helper\Auth;
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
        private UserRepositoryInterface $repository,
        private Auth $auth
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
        } catch (UserWithEmailExistsException) {
            throw new HttpUserWithEmailExistsException();
        }

        return $this->json($response);
    }

    #[Route(path: '/api/user/{id}', requirements: ['id' => Requirement::UUID_V4],  methods: 'GET')]
    public function getPublicDataById(string $id): JsonResponse
    {
        try {
            $userData = $this->repository->getPublicDataById(new Uuid($id));

            return $this->json($userData);
        } catch (UserNotFoundException) {
            throw new HttpUserNotFoundException();
        }
    }

    #[Route(path: '/api/user/{id}', requirements: ['id' => Requirement::UUID_V4], methods: 'DELETE')]
    public function deleteById(#[ValueResolver('auth_access_token')] AccessTokenUserData $userData, string $id): JsonResponse
    {
        $this->auth->hasRolesOrException($userData, Role::Admin);

        try {
            $this->service->deleteById(new Uuid($id));

            return $this->json([], 204);
        } catch (UserNotFoundException) {
            throw new HttpUserNotFoundException();
        }
    }
}