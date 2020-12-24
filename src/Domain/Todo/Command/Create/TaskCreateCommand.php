<?php

declare(strict_types=1);

namespace App\Domain\Todo\Command\Create;

use App\Domain\Todo\Command\CommandInterface;
use DateTime;
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
     */
    private $dueDate;

    /**
     * TaskCreateCommand constructor.
     * @param string $content
     * @param DateTime $dateTime
     */
    public function __construct(string $content, DateTime $dateTime)
    {
        $this->content = $content;
        $this->dueDate = $dateTime;
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
}
