<?php

namespace App\Utils\Infrastructure\Doctrine\EventListener;

use App\Utils\Domain\Bus\DomainEventBusInterface;
use App\Utils\Domain\Entity\RootAggregate;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::onFlush)]
class DomainEventsListener
{
    public function __construct(
        private DomainEventBusInterface $bus
    ) {}

    public function onFlush(OnFlushEventArgs $args)
    {
        $unitOfWork = $args->getObjectManager()->getUnitOfWork();
        $entities = [
            ...$unitOfWork->getScheduledEntityInsertions(),
            ...$unitOfWork->getScheduledEntityUpdates(),
            ...$unitOfWork->getScheduledEntityDeletions(),
            ...$unitOfWork->getScheduledCollectionDeletions(),
            ...$unitOfWork->getScheduledCollectionUpdates()
        ];

        foreach ($entities as $entity) {
            if ($entity instanceof RootAggregate) {
                foreach ($entity->getEvents() as $event) {
                    $this->bus->register($event);
                }
            }
        }
    }
}