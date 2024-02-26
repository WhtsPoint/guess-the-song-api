<?php

namespace App\Utils\Domain\Bus;

use App\Utils\Domain\Bus\Events\DomainEvent;

interface DomainEventBusInterface
{
    public function register(DomainEvent $event): void;
}