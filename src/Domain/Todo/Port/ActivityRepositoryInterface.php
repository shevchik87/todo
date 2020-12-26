<?php

declare(strict_types=1);

namespace App\Domain\Todo\Port;

use App\Domain\Todo\Entity\ActivityEntity;
use Doctrine\Common\Collections\ArrayCollection;

interface ActivityRepositoryInterface
{
    public function add(ActivityEntity $entity);
    public function getByTaskId(int $id): ArrayCollection;
}
