<?php

declare(strict_types=1);

namespace App\Domain\Todo\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ActivityEntity
 * @package App\Domain\Todo\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="activities")
 */
class ActivityEntity
{
    const CREATE_EVENT = 1;
    const COMPLETE_EVENT = 2;

    /**
     * @var integer
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(type="integer", name="task_id")
     */
    private $taskId;

    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $operation;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @var array
     * @ORM\Column(type="json")
     */
    private $extraData;

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
     * @return int
     */
    public function getTaskId(): int
    {
        return $this->taskId;
    }

    /**
     * @param int $taskId
     * @return $this
     */
    public function setTaskId(int $taskId)
    {
        $this->taskId = $taskId;
        return $this;
    }

    /**
     * @return int
     */
    public function getOperation(): int
    {
        return $this->operation;
    }

    /**
     * @param int $operation
     * @return $this
     */
    public function setOperation(int $operation)
    {
        $this->operation = $operation;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return array
     */
    public function getExtraData(): array
    {
        return $this->extraData;
    }

    /**
     * @param array $extraData
     * @return $this
     */
    public function setExtraData(array $extraData)
    {
        $this->extraData = $extraData;
        return $this;
    }
}
