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
        $em = $this->getEntityManager();
        $em->persist($entity);
        $em->flush();

        return $entity;
    }

    public function save(TaskEntity $entity): void
    {
        $em = $this->getEntityManager();
        $em->persist($entity);
        $em->flush();
    }

    public function get(int $id): TaskEntity
    {
        return $this->find($id);
    }
}
