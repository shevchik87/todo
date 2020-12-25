<?php

declare(strict_types=1);

namespace App\Domain\Todo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserEntity
 * @package App\Domain\Todo\Entity
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class UserEntity implements UserInterface
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id()
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="user_name", type="string", unique=true)
     */
    private $userName;

    /**
     * @var string
     * @ORM\Column(name="token", type="string", unique=true)
     */
    private $token;

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
     * @param string $userName
     * @return $this
     */
    public function setUserName(string $userName)
    {
        $this->userName = $userName;
        return $this;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken(string $token)
    {
        $this->token = $token;
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
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    public function getRoles()
    {
        return [];
    }

    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->userName;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }


}
