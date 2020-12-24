<?php

declare(strict_types=1);

namespace App\Infrastructure\EventBus;

use App\Domain\Todo\DomainEvent\TodoDomainEvent;
use App\Domain\Todo\Port\EventPublisherInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventDispatcherSync implements EventPublisherInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * EventDispatcherSync constructor.
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function publish(TodoDomainEvent $event)
    {
        $this->dispatcher->dispatch($event);
    }
}
