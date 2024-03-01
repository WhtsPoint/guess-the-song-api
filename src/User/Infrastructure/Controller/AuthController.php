<?php

namespace App\User\Infrastructure\Controller;

use App\User\Application\Dto\LoginCredentialsDto;
use App\User\Application\Exception\InvalidCredentialsException;
use App\User\Application\Service\AuthService;
use App\User\Domain\Exception\UserNotFoundException;
use App\User\Infrastructure\Exception\HttpInvalidCredentialsException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    public function __construct(
        private AuthService $service
    ) {}

    #[Route(path: '/api/auth/login', methods: 'GET')]
    public function login(#[ValueResolver('map_request_payload')] LoginCredentialsDto $dto): JsonResponse
    {
        try {
            $response = $this->service->login($dto);

            return $this->json($response);
        } catch (InvalidCredentialsException|UserNotFoundException) {
            throw new HttpInvalidCredentialsException();
        }
    }
}