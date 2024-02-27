<?php

namespace App\User\Infrastructure\Controller;

use App\User\Application\Dto\UserCreationDto;
use App\User\Application\Service\UserService;
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
        $response = $this->service->createAndCommit(new UserCreationDto(
            bin2hex(random_bytes(10)),
            'never',
            new Email('whtspoint@gmail.com')
        ));

        return $this->json($response);
    }
}