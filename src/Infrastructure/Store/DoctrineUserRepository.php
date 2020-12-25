<?php

declare(strict_types=1);

namespace App\Infrastructure\Store;

use App\Domain\Todo\Entity\UserEntity;
use App\Domain\Todo\Port\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineUserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEntity::class);
    }


    public function findByToken(string $token): UserEntity
    {
        return new UserEntity();
    }

}
