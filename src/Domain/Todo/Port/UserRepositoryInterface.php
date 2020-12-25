<?php

declare(strict_types=1);

namespace App\Domain\Todo\Port;

use App\Domain\Todo\Entity\UserEntity;

interface UserRepositoryInterface
{
    public function findByToken(string $token): UserEntity;
}
