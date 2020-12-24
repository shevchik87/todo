<?php

declare(strict_types=1);

namespace App\Infrastructure\Store;

use App\Domain\Todo\Entity\TaskEntity;
use App\Domain\Todo\Port\TaskRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineTaskRepository extends ServiceEntityRepository implements TaskRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskEntity::class);
    }

    public function add(TaskEntity $entity): TaskEntity
    {
        // TODO: Implement add() method.
    }

    public function save(TaskEntity $entity): void
    {
        // TODO: Implement save() method.
    }
}