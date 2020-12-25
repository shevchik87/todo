<?php

declare(strict_types=1);

namespace App\Domain\Todo\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class TaskEntity
 * @package App\Domain\Todo\Entity
 * @ORM\Entity()
 */
class TaskEntity
{
    const STATUS_NEW = 10;
    const STATUS_COMPLETE = 20;
    const STATUS_ARCHIVE = 30;
    const STATUS_DELETED = 40;

    /**
     * @var integer
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="integer", name="user_id")
     */
    private $userId;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @var string
     * @ORM\Column(name="due_date", type="date")
     */
    private $dueDate;

    /**
     * @var DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var DateTime
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var int
     * @ORM\Column(type="smallint", name="status")
     */
    private $status;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getDueDate(): ?string
    {
        return $this->dueDate;
    }

    /**
     * @param string $dueDate
     * @return $this
     */
    public function setDueDate(?string $dueDate)
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
        return $this;
    }
}
