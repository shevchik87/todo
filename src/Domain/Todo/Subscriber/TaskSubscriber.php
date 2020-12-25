<?php

declare(strict_types=1);

namespace App\Domain\Todo\Subscriber;

use App\Domain\Todo\DomainEvent\TaskCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TaskSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            TaskCreatedEvent::class => ['onCreate']
        ];
    }

    public function onCreate(TaskCreatedEvent $event)
    {
        var_dump($event);
    }
}
