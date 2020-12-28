<?php

declare(strict_types=1);

namespace App\Infrastructure\Store;

use App\Domain\Todo\Entity\TaskEntity;
use App\Domain\Todo\Port\TaskReadRepositoryInterface;
use App\Domain\Todo\Port\TaskWriteRepositoryInterface;
use App\Domain\Todo\Query\Task\TaskQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineTaskWriteRepository extends ServiceEntityRepository implements TaskWriteRepositoryInterface, TaskReadRepositoryInterface
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

    public function getByQuery(TaskQuery $query): array
    {
        $qb = $this->createQueryBuilder('t')
            ->where('t.userId = :userId')
            ->setParameter('userId', $query->getUserId());

        if ($query->getSpecificDate()) {
            $qb
                ->andWhere('t.dueDate = :date')
                ->setParameter('date', $query->getSpecificDate());
        }

        if ($query->isOnlyActive()) {
            $qb->andWhere('t.status = 10');
        }

        $qb->setMaxResults($query->getLimit());

        return  $qb->getQuery()->getResult();
    }
}
