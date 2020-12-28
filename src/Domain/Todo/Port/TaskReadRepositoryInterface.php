<?php

declare(strict_types=1);

namespace App\Domain\Todo\Port;

use App\Domain\Todo\Entity\TaskEntity;
use App\Domain\Todo\Query\Task\TaskQuery;

interface TaskReadRepositoryInterface
{
    public function get(int $id): TaskEntity;
    public function getByQuery(TaskQuery $query): array;
}
