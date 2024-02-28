<?php

namespace App\Utils\Infrastructure\Validation\Resolver;

use App\Utils\Infrastructure\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsTargetedValueResolver;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

#[AsTargetedValueResolver('map_request_payload')]
class RequestPayloadResolver implements ValueResolverInterface
{
    public function __construct(
        private RequestDataResolver $resolver
    ) {}

    /**
     * @throws ValidationException
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        return $this->resolver->resolve($request->getPayload()->all(), $argument);
    }
}