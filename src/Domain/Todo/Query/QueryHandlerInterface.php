<?php

declare(strict_types=1);

namespace App\Domain\Todo\Query;

use App\Domain\Todo\Query\Activity\QueryInterface;

interface QueryHandlerInterface
{
    public function execute(QueryInterface $query);
}
