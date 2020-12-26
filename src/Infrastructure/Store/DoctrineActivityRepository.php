<?php

declare(strict_types=1);

namespace App\Infrastructure\Store;

use App\Domain\Todo\Entity\ActivityEntity;
use App\Domain\Todo\Port\ActivityRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineActivityRepository extends ServiceEntityRepository implements ActivityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivityEntity::class);
    }

    public function add(ActivityEntity $entity)
    {
        $em = $this->getEntityManager();
        $em->persist($entity);
        $em->flush();
    }

    public function getByTaskId(int $id): ArrayCollection
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.taskId = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult()
            ;
    }

}
