<?php

declare(strict_types=1);

namespace App\Domain\Todo\Port;

use App\Domain\Todo\Entity\TaskEntity;

interface TaskRepositoryInterface
{

    public function get(int $id): TaskEntity;
    public function add(TaskEntity $entity): TaskEntity;
    public function save(TaskEntity $entity): void;
}
