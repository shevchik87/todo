<?php

declare(strict_types=1);

namespace App\Domain\Todo\Command\Create;

use App\Domain\Todo\Command\AbstractCommandHandler;
use App\Domain\Todo\Command\CommandInterface;
use App\Domain\Todo\DomainEvent\TaskCreatedEvent;
use App\Domain\Todo\DomainEvent\TodoDomainEvent;
use App\Domain\Todo\Entity\TaskEntity;

class TaskCreateHandler extends AbstractCommandHandler
{
    public function handle(CommandInterface $command): TodoDomainEvent
    {
        $task = new TaskEntity();
        $task
            ->setContent($command->getContent())
            ->setDueDate($command->getDueDate())
            ->setStatus(TaskEntity::STATUS_NEW)
            ->setCreatedAt(new \DateTime());

        $task = $this->repository->add($task);

        return new TaskCreatedEvent($task);
    }
}
