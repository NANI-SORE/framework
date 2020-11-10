<?php

declare(strict_types=1);

namespace Service\User;

use Model;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Security implements ISecurity
{
    private const SESSION_USER_IDENTITY = 'userId';
    private const SESSION_USER_LAST_ORDER = 'lastOrder';

    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @inheritdoc
     */
    public function getUser(): ?Model\Entity\User
    {
        $userId = $this->session->get(self::SESSION_USER_IDENTITY);

        return $userId ? (new Model\Repository\User())->getById($userId) : null;
    }

    /**
     * @inheritdoc
     */
    public function isLogged(): bool
    {
        return $this->getUser() instanceof Model\Entity\User;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        if ($this->isLogged()) {
            return $this->getUser()->getRole()->getType() === "admin";
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function authentication(string $login, string $password): bool
    {
        $user = $this->getUserRepository()->getByLogin($login);

        if ($user === null) {
            return false;
        }

        if (!password_verify($password, $user->getPasswordHash())) {
            return false;
        }

        $this->session->set(self::SESSION_USER_IDENTITY, $user->getId());

        // Здесь могут выполняться другие действия связанные с аутентификацией пользователя

        return true;
    }

    /**
     * @inheritdoc
     */
    public function logout(): void
    {
        $this->session->set(self::SESSION_USER_IDENTITY, null);
        $this->session->set(self::SESSION_USER_LAST_ORDER, 0);

        // Здесь могут выполняться другие действия связанные с разлогиниванием пользователя
    }

    /**
     * @inheritdoc
     */
    public function getLastOrder(): float
    {
        $lastOrder = $this->session->get(self::SESSION_USER_LAST_ORDER) OR 0;
        return $lastOrder;
    }

    /**
     * @inheritdoc
     */
    public function setLastOrder(float $orderPrice = 0): void
    {
        $user = $this->getUser();
        $user->setLastOrder($orderPrice);
        $this->session->set(self::SESSION_USER_LAST_ORDER, $orderPrice);
    }

    /**
     * Фабричный метод для репозитория User
     *
     * @return Model\Repository\User
     */
    protected function getUserRepository(): Model\Repository\User
    {
        return new Model\Repository\User();
    }
}
