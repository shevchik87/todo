<?php

declare(strict_types=1);

namespace App\Domain\Todo\Command\Complete;

use App\Domain\Todo\Command\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class TaskCompleteCommand implements CommandInterface
{
    /**
     * @var integer
     * @Assert\NotBlank()
     */
    private $taskId;

    /**
     * TaskCompleteCommand constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->taskId = $id;
    }

    /**
     * @return int
     */
    public function getTaskId(): int
    {
        return $this->taskId;
    }
}
