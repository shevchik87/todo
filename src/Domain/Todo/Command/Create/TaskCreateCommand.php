<?php

declare(strict_types=1);

namespace App\Domain\Todo\Command\Create;

use App\Domain\Todo\Command\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class TaskCreateCommand implements CommandInterface
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @var string|null
     * @Assert\Date()
     */
    private $dueDate;

    /**
     * @var integer
     * @Assert\NotBlank()
     */
    private $userId;

    /**
     * TaskCreateCommand constructor.
     * @param int $userId
     * @param string $content
     * @param string|null $dateTime
     *
     */
    public function __construct(int $userId, string $content, string $dateTime = null)
    {
        $this->content = $content;
        $this->dueDate = $dateTime;
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string|null
     */
    public function getDueDate(): ?string
    {
        return $this->dueDate;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}
