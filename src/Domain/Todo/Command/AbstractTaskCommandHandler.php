<?php

declare(strict_types=1);

namespace App\Domain\Todo\Command;

use App\Domain\Todo\Entity\TaskEntity;
use App\Domain\Todo\Exception\DomainException;
use App\Domain\Todo\Port\EventPublisherInterface;
use App\Domain\Todo\Port\TaskRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractTaskCommandHandler
{

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var TaskRepositoryInterface
     */
    protected $repository;

    /**
     * @var EventPublisherInterface
     */
    protected $publisher;

    /**
     * TaskCreateHandlerTask constructor.
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
     * @param CommandInterface $command
     * @return TaskEntity
     * @throws DomainException
     */
    public function execute(CommandInterface $command)
    {
        $errors = $this->validator->validate($command);
        if (count($errors) > 0) {
            throw new DomainException($errors[0]->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $taskEntity = $this->handle($command);
        foreach ($taskEntity->getEvents() as $event) {
            $this->publisher->publish($event);
        }

        return $taskEntity;
    }

    abstract protected function handle(CommandInterface $command): TaskEntity;
}
