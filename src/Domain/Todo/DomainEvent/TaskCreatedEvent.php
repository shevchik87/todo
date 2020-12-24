<?php

declare(strict_types=1);

namespace App\Domain\Todo\DomainEvent;

use App\Domain\Todo\Entity\TaskEntity;
use DateTime;

class TaskCreatedEvent implements TodoDomainEvent
{
    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var integer
     */
    private $taskId;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $dueDate;

    /**
     * TaskCreatedEvent constructor.
     * @param TaskEntity $taskEntity
     */
    public function __construct(TaskEntity $taskEntity)
    {
        $this->dateTime = $taskEntity->getCreatedAt();
        $this->taskId = $taskEntity->getId();
        $this->content = $taskEntity->getContent();
        $this->dueDate = $taskEntity->getDueDate();
    }

    /**
     * @return int
     */
    public function getTaskId(): int
    {
        return $this->taskId;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    public function getEventDate(): DateTime
    {
        return $this->dateTime;
    }
}
