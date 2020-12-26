<?php

declare(strict_types=1);

namespace App\Domain\Todo\Command\Complete;

use App\Domain\Todo\Command\AbstractTaskCommandHandler;
use App\Domain\Todo\Command\CommandInterface;
use App\Domain\Todo\DomainEvent\TaskCompletedEvent;
use App\Domain\Todo\Entity\TaskEntity;

class TaskCompleteHandlerTask extends AbstractTaskCommandHandler
{
    /**
     * @param CommandInterface|TaskCompleteCommand $command
     * @return TaskEntity
     */
    protected function handle(CommandInterface $command): TaskEntity
    {
        $entity = $this->repository->get($command->getTaskId());

        if ($entity->getStatus() === TaskEntity::STATUS_COMPLETE) {
            return $entity;
        }

        $entity->setStatus(TaskEntity::STATUS_COMPLETE);

        $this->repository->save($entity);

        $entity->setEvents(new TaskCompletedEvent($command->getTaskId()));

        return $entity;
    }

}
