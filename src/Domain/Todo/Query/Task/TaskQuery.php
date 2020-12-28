<?php

declare(strict_types=1);

namespace App\Domain\Todo\Query\Task;

use App\Domain\Todo\Query\Activity\QueryInterface;
use Symfony\Component\Validator\Constraints as Assert;

class TaskQuery implements QueryInterface
{
    /**
     * @var int
     * @Assert\NotBlank()
     */
    private $userId;

    /**
     * @var bool
     */
    private $onlyActive = true;

    /**
     * @var string|null
     * @Assert\Date()
     */
    private $specificDate;

    /**
     * @var integer|null
     */
    private $limit;

    /**
     * @var integer|null
     */
    private $offset;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return bool
     */
    public function isOnlyActive(): bool
    {
        return $this->onlyActive;
    }

    /**
     * @param bool $onlyActive
     * @return $this
     */
    public function setOnlyActive(bool $onlyActive)
    {
        $this->onlyActive = $onlyActive;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSpecificDate(): ?string
    {
        return $this->specificDate;
    }

    /**
     * @param string|null $specificDate
     * @return $this
     */
    public function setSpecificDate(?string$specificDate)
    {
        $this->specificDate = $specificDate;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @param int|null $limit
     * @return $this
     */
    public function setLimit(?int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @param int|null $offset
     * @return $this
     */
    public function setOffset(?int $offset)
    {
        $this->offset = $offset;
        return $this;
    }
}
