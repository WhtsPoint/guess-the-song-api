<?php

namespace App\Utils\Infrastructure\Bus;

use App\Utils\Domain\Bus\DomainEventBusInterface;
use App\Utils\Domain\Bus\Events\DomainEvent;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

class DomainEventBus implements DomainEventBusInterface
{
    public function __construct(
        private MessageBusInterface $bus
    ) {}

    public function register(DomainEvent $event): void
    {
        $this->bus->dispatch(
            (new Envelope($event))->with(new DispatchAfterCurrentBusStamp())
        );
    }
}