<?php

declare(strict_types = 1);

namespace Model\Entity;

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $passwordHash;

    /**
     * @var Role
     */
    private $role;

    /**
     * @var int
     */
    private $birthday;

    /**
     * @var float
     */
    private $lastOrder;

    /**
     * @param int $id
     * @param string $name
     * @param string $login
     * @param string $password
     * @param Role $role
     * @param int $birthday
     * @param float $lastOrder
     */
    public function __construct(int $id, string $name, string $login, string $password, Role $role, int $birthday, float $lastOrder = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->login = $login;
        $this->passwordHash = $password;
        $this->role = $role;
        $this->birthday = $birthday;
        $this->lastOrder = $lastOrder;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @return int
     */
    public function getBirthday(): int
    {
        return $this->birthday;
    }

    /**
     * @return float
     */
    public function getLastOrder(): float
    {
        return $this->lastOrder;
    }

    /**
     * @param string $
     */
    public function setLastOrder(float $lastOrder = 0): float
    {
        $this->lastOrder = $lastOrder;

        return $this->lastOrder;
    }
}
