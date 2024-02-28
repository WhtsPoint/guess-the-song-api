<?php

namespace App\User\Infrastructure\Controller;

use App\User\Application\Dto\UserCreationDto;
use App\User\Application\Service\UserService;
use App\User\Domain\Exception\UserWithUsernameExistsException;
use App\User\Infrastructure\Exception\HttpUserWithUsernameExistsException;
use App\Utils\Domain\ValueObject\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    public function __construct(
        private UserService $service
    ) {}

    #[Route(path: '/api/user')]
    public function test(): JsonResponse {
        try {
            $response = $this->service->createAndCommit(new UserCreationDto(
                'a',
                'never',
                new Email('whtspoint@gmail.com')
            ));
        } catch (UserWithUsernameExistsException) {
            throw new HttpUserWithUsernameExistsException();
        }
        return $this->json($response);
    }
}