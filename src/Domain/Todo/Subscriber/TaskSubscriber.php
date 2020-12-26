<?php

declare(strict_types=1);

namespace App\Domain\Todo\Subscriber;

use App\Domain\Todo\DomainEvent\TaskCompletedEvent;
use App\Domain\Todo\DomainEvent\TaskCreatedEvent;
use App\Domain\Todo\Entity\ActivityEntity;
use App\Domain\Todo\Port\ActivityRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TaskSubscriber implements EventSubscriberInterface
{
    private $repository;

    public function __construct(ActivityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public static function getSubscribedEvents()
    {
        return [
            TaskCreatedEvent::class => ['onCreated'],
            TaskCompletedEvent::class => ['onCompleted']
        ];
    }

    /**
     * @param TaskCreatedEvent $event
     */
    public function onCreated(TaskCreatedEvent $event)
    {
        $entity = new ActivityEntity();
        $entity
            ->setCreatedAt(new \DateTime())
            ->setTaskId($event->getTaskId())
            ->setOperation(ActivityEntity::CREATE_EVENT);

        $this->repository->add($entity);
    }

    public function onCompleted(TaskCompletedEvent $event)
    {
        $entity = new ActivityEntity();
        $entity
            ->setCreatedAt(new \DateTime())
            ->setTaskId($event->getTaskId())
            ->setOperation(ActivityEntity::COMPLETE_EVENT);

        $this->repository->add($entity);
    }
}
