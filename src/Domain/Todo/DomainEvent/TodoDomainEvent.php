<?php

declare(strict_types=1);

namespace App\Domain\Todo\DomainEvent;

use DateTime;

interface TodoDomainEvent
{
    public function getEventDate(): DateTime;
}
