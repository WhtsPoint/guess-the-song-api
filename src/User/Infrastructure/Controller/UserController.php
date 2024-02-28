<?php

namespace App\User\Infrastructure\Controller;

use App\User\Application\Dto\UserCreationDto;
use App\User\Application\Service\UserService;
use App\User\Domain\Exception\UserWithUsernameExistsException;
use App\User\Infrastructure\Dto\UserCreationDataDto;
use App\User\Infrastructure\Exception\HttpUserWithUsernameExistsException;
use App\Utils\Domain\ValueObject\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    public function __construct(
        private UserService $service
    ) {}

    #[Route(path: '/api/user', methods: 'POST')]
    public function test(#[ValueResolver('map_request_payload')] UserCreationDataDto $dto): JsonResponse {
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
}