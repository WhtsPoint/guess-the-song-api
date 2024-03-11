<?php

namespace App\User\Infrastructure\Resolver;

use App\User\Domain\Exception\InvalidJWTException;
use App\User\Domain\Exception\TokenExpiredException;
use App\User\Domain\Helper\JWTInterface;
use Firebase\JWT\ExpiredException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsTargetedValueResolver;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

#[AsTargetedValueResolver('auth_access_token')]
class AuthResolver implements ValueResolverInterface
{
    public function __construct(
        private JWTInterface $JWT
    ) {}

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $auth = $request->headers->get('Authorization');

        if ($auth === null) {
            throw new UnauthorizedHttpException('', 'JWT missing', code: 1101);
        }

        if (preg_match('/^Bearer\s(.+)$/', $auth, $matches) !== 1) {
            throw new UnauthorizedHttpException('', 'Invalid JWT format', code: 1102);
        }

        try {
            return [$this->JWT->decodeAccess($matches[1])];
        } catch (InvalidJWTException $exception) {
            throw new UnauthorizedHttpException('', $exception->getMessage(), code: 1103);
        } catch (TokenExpiredException) {
            throw new UnauthorizedHttpException('', 'Access token expired', code: 1104);
        }
    }
}