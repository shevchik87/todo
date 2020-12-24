<?php

declare(strict_types=1);

namespace App\Domain\Todo\Command\Create;

use App\Domain\Todo\Command\CommandHandlerInterface;
use App\Domain\Todo\Command\CommandInterface;
use App\Domain\Todo\DomainEvent\TaskCreatedEvent;
use App\Domain\Todo\Entity\TaskEntity;
use App\Domain\Todo\Exception\DomainException;
use App\Domain\Todo\Port\EventPublisherInterface;
use App\Domain\Todo\Port\TaskRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskCreateHandler implements CommandHandlerInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var TaskRepositoryInterface
     */
    private $repository;

    /**
     * @var EventPublisherInterface
     */
    private $publisher;

    /**
     * TaskCreateHandler constructor.
     * @param ValidatorInterface $validator
     * @param TaskRepositoryInterface $repository
     * @param EventPublisherInterface $publisher
     */
    public function __construct(ValidatorInterface $validator, TaskRepositoryInterface $repository, EventPublisherInterface $publisher)
    {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->publisher = $publisher;
    }

    /**
     * @param CommandInterface|TaskCreateCommand $command
     * @throws DomainException
     */
    public function execute(CommandInterface $command)
    {
        $errors = $this->validator->validate($command);
        if (count($errors) > 0) {
            throw new DomainException($errors[0]->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $task = new TaskEntity();
        $task
            ->setContent($command->getContent())
            ->setDueDate($command->getDueDate())
            ->setStatus(TaskEntity::STATUS_NEW)
            ->setCreatedAt(new \DateTime());

        $task = $this->repository->add($task);

        $this->publisher->publish(new TaskCreatedEvent($task));
    }
}
