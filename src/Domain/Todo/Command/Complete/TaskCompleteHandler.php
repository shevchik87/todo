<?php

declare(strict_types=1);

namespace App\Domain\Todo\Command\Complete;

use App\Domain\Todo\Command\AbstractCommandHandler;
use App\Domain\Todo\Command\CommandInterface;
use App\Domain\Todo\DomainEvent\TaskCompletedEvent;
use App\Domain\Todo\DomainEvent\TodoDomainEvent;
use App\Domain\Todo\Entity\TaskEntity;

class TaskCompleteHandler extends AbstractCommandHandler
{
    /**
     * @param CommandInterface|TaskCompleteCommand $command
     * @return TodoDomainEvent
     */
    public function handle(CommandInterface $command): TodoDomainEvent
    {
        $entity = $this->repository->get($command->getTaskId());

        $entity->setStatus(TaskEntity::STATUS_COMPLETE);

        $this->repository->save($entity);

        return new TaskCompletedEvent($command->getTaskId());
    }

}
