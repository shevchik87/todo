<?php

declare(strict_types=1);

namespace App\Domain\Todo\Entity;

use App\Domain\Todo\DomainEvent\TodoDomainEvent;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;


/**
 * Class TaskEntity
 * @package App\Domain\Todo\Entity
 * @ORM\Entity()
 * @ORM\Table(name="tasks")
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
     *
     * @Serializer\Groups({"create"})
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="integer", name="user_id")
     * @Serializer\Groups({"create"})
     */
    private $userId;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Serializer\Groups({"create"})
     */
    private $content;

    /**
     * @var DateTime|null
     * @ORM\Column(name="due_date", type="date")
     * @Serializer\Groups({"create"})
     */
    private $dueDate;

    /**
     * @var DateTime
     * @ORM\Column(name="created_at", type="datetime")
     * @Serializer\Groups({"create"})
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
     * @Serializer\Groups({"create"})
     */
    private $status;

    /**
     * @var array
     */
    private $events = [];

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return $this
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
        return $this;
    }

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
     * @return DateTime|null
     */
    public function getDueDate(): ?DateTime
    {
        return $this->dueDate;
    }

    /**
     * @param DateTime $dueDate
     * @return $this
     */
    public function setDueDate(?DateTime $dueDate)
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

    public function setEvents(TodoDomainEvent $event)
    {
        $this->events[] = $event;
    }

    public function getEvents()
    {
        return $this->events;
    }
}
