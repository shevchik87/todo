<?php

declare(strict_types=1);

namespace App\Domain\Todo\Command;

interface CommandHandlerInterface
{
    public function execute(CommandInterface $command);
}
