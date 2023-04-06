<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Listener;

use App\Entity\Contract\ActorAwareInterface;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;

final class ActorAwareSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly Security $security)
    {
    }

    /**
     * @return string[]
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $this->setActor($args->getObject());
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $this->setActor($args->getObject());
    }

    private function setActor(object $object): void
    {
        if ($object instanceof ActorAwareInterface === false) {
            return;
        }

        /** @var null|\App\Infrastructure\Security\Auth0\Auth0User $user */
        $user = $this->security->getUser();
        $user = $user?->getDbUser();

        if ($user === null) {
            throw new \LogicException('User required to be logged in');
        }

        if ($object->getCreatedBy() === null) {
            $object->setCreatedBy($user);
        }

        $object->setUpdatedBy($user);
    }
}