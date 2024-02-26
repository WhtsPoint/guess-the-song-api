<?php

namespace App\User\Infrastructure\Bus\Handler;

use App\User\Domain\Bus\Events\OnEmailConfirmationRefreshed;
use App\User\Infrastructure\Api\EmailApi;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class OnEmailConfirmationRefreshedHandler
{
    public function __construct(
        private EmailApi $api
    ) {}

    public function __invoke(OnEmailConfirmationRefreshed $event)
    {
        $this->api->onConfirmationCodeRefresh($event->email->get(), $event->code);
    }
}