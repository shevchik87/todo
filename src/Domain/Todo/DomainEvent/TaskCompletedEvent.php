<?php

declare(strict_types=1);

namespace App\Domain\Todo\DomainEvent;

use DateTime;

class TaskCompletedEvent implements TodoDomainEvent
{
    /**
     * @var int
     */
    private $taskId;

    /**
     * @var DateTime
     */
    private $eventDate;

    public function __construct(int $taskId)
    {
        $this->taskId = $taskId;
        $this->eventDate = new DateTime();
    }

    public function getEventDate(): DateTime
    {
        return $this->eventDate;
    }

    /**
     * @return int
     */
    public function getTaskId(): int
    {
        return $this->taskId;
    }
}
