<?php

declare(strict_types=1);

namespace App\Domain\Todo\Port;

use App\Domain\Todo\DomainEvent\TodoDomainEvent;

interface EventPublisherInterface
{
    public function publish(TodoDomainEvent $event);
}
