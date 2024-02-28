<?php

namespace App\Utils\Infrastructure\Http\EventListener;


use App\Utils\Infrastructure\Http\JsonErrorResponse;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

#[AsEventListener(event: 'kernel.exception')]
class HttpExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HttpException === false) return;

        $response = new JsonErrorResponse(
            $exception->getMessage(),
            $exception->getStatusCode(),
            $exception->getCode()
        );

        $event->setResponse($response);
    }
}