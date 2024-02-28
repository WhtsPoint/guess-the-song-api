<?php

namespace App\Utils\Infrastructure\Validation\EventListener;


use App\Utils\Infrastructure\Exception\ValidationException;
use App\Utils\Infrastructure\Http\JsonErrorResponse;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

#[AsEventListener(event: 'kernel.exception')]
class ValidationExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ValidationException === false) return;

        $event->setResponse(new JsonErrorResponse(
            $exception->getErrors(),
            422
        ));
    }
}