<?php

declare(strict_types=1);

namespace App\Domain\Todo\Command;

use App\Domain\Todo\Command\Create\TaskCreateCommand;
use App\Domain\Todo\DomainEvent\TaskCreatedEvent;
use App\Domain\Todo\DomainEvent\TodoDomainEvent;
use App\Domain\Todo\Entity\TaskEntity;
use App\Domain\Todo\Exception\DomainException;
use App\Domain\Todo\Port\EventPublisherInterface;
use App\Domain\Todo\Port\TaskRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractCommandHandler
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

        $event = $this->handle($command);
        $this->publisher->publish($event);
    }

    abstract public function handle(CommandInterface $command): TodoDomainEvent;
}
