<?php

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class UpdateTimestampListener implements EventSubscriber
{
    private ?string $username;

    public function __construct(Security $security)
    {
        $user = $security->getUser();
        $this->username = $user ? $user->getUserIdentifier() : 'system';
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::preUpdate,
            Events::prePersist,
        ];
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        if (method_exists($entity, 'setUpdatedAt')) {
            $entity->setUpdatedAt(new \DateTimeImmutable());
        }

        if (method_exists($entity, 'setCreatedBy' )) {
            $entity->setUpdatedBy($this -> $username);
        }
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        if (method_exists($entity, 'setUpdatedAt')) {
            $entity->setUpdatedAt(new \DateTimeImmutable());
        }
        if (method_exists($entity, 'setCreatedBy' )) {
            $entity->setCreatedBy($this -> $username);
            $entity->setUpdatedBy($this -> $username);
        }
    }
}
