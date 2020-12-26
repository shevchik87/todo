<?php

declare(strict_types=1);

namespace App\Domain\Todo\Command\Create;

use App\Domain\Todo\Command\AbstractTaskCommandHandler;
use App\Domain\Todo\Command\CommandInterface;
use App\Domain\Todo\DomainEvent\TaskCreatedEvent;
use App\Domain\Todo\DomainEvent\TodoDomainEvent;
use App\Domain\Todo\Entity\TaskEntity;

class TaskCreateHandlerTask extends AbstractTaskCommandHandler
{
    /**
     * @param CommandInterface $command
     * @return TaskEntity
     * @throws \Exception
     */
    public function handle(CommandInterface $command): TaskEntity
    {
        $date = null;
        if ($command->getDueDate()) {
            $date = \DateTime::createFromFormat("Y-m-d", $command->getDueDate());
        }
        $task = new TaskEntity();
        $task
            ->setContent($command->getContent())
            ->setDueDate($date)
            ->setUserId($command->getUserId())
            ->setStatus(TaskEntity::STATUS_NEW)
            ->setCreatedAt(new \DateTime());

        $task = $this->repository->add($task);

        $task->setEvents(new TaskCreatedEvent($task));

        return $task;
    }
}
