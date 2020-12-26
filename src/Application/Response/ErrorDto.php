<?php

declare(strict_types=1);

namespace App\Application\Response;

class ErrorDto implements \JsonSerializable
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $userMessage;

    /**
     * @var string
     */
    private $developMessage;

    /**
     * ErrorDto constructor.
     * @param string $userMessage
     * @param string $developMessage
     * @param int $code
     */
    public function __construct(string $userMessage, string $developMessage = '', int $code = 0)
    {
        $this->userMessage = $userMessage;
        $this->developMessage = $developMessage;
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getUserMessage(): string
    {
        return $this->userMessage;
    }

    /**
     * @return string
     */
    public function getDevelopMessage(): string
    {
        return $this->developMessage;
    }


    public function jsonSerialize()
    {
        return [
            'user_message' => $this->userMessage,
            'develop_message' => $this->developMessage,
            'code' => $this->code
        ];
    }
}
