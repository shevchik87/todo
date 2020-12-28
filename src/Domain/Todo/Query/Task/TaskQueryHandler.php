<?php

declare(strict_types=1);

namespace App\Domain\Todo\Query\Task;

use App\Domain\Todo\Exception\DomainException;
use App\Domain\Todo\Port\TaskReadRepositoryInterface;
use App\Domain\Todo\Query\Activity\QueryInterface;
use App\Domain\Todo\Query\QueryHandlerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskQueryHandler implements QueryHandlerInterface
{
    private $readRepository;
    private $validator;

    public function __construct(TaskReadRepositoryInterface $repository, ValidatorInterface $validator)
    {
        $this->readRepository = $repository;
        $this->validator = $validator;
    }

    public function execute(QueryInterface $query)
    {
        $errors = $this->validator->validate($query);
        if (count($errors) > 0) {
            throw new DomainException($errors[0]->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $this->readRepository->getByQuery($query);
    }

}
