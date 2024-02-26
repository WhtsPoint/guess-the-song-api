<?php

namespace App\User\Infrastructure\Doctrine\EventListener;

use App\User\Domain\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postLoad, method: 'postLoad', entity: User::class)]
class UserEventListener
{
    public function postLoad(User $user): void
    {
        if ($user->getEmail() === null) {
            $user->setEmail(null);
        }
    }
}