<?php

namespace App\User\Application\Bus\Handler;

use App\User\Application\Api\EmailApiInterface;
use App\User\Domain\Bus\Events\OnEmailConfirmationRefreshed;

class OnEmailConfirmationRefreshedHandler
{
    public function __construct(
        private EmailApiInterface $api
    ) {}

    public function __invoke(OnEmailConfirmationRefreshed $event): void
    {
        $this->api->onConfirmationCodeRefresh($event->email->get(), $event->code);
    }
}