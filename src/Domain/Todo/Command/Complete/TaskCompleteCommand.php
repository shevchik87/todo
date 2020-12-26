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
     * @param int $taskId
     * @param int $userId
     */
    public function __construct(int $taskId)
    {
        $this->taskId = $taskId;
    }

    /**
     * @return int
     */
    public function getTaskId(): int
    {
        return $this->taskId;
    }
}
