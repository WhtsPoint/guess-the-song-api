<?php

namespace App\Utils\Domain\Entity;

use App\Utils\Domain\Events\DomainEvent;

abstract class RootAggregate
{
    /**
     * @var DomainEvent[]
     */
    private array $events = [];
    public function pushEvent(DomainEvent $event): void
    {
        $this->events []= $event;
    }

    /**
     * @return DomainEvent[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}