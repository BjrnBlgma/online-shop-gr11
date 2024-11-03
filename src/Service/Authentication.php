<?php
namespace Service;
use Model\User;

class Authentication
{
    public function login(string $login, string $password): bool
    {
//        $_SESSION['user_id'] = $name;
        $data = User::getByEmail($login);
        if (empty($data) and !password_verify($password, $data->getPassword())) {
            return false;
//            $userSession = $data->getId();
//            $this->authentication->login($userSession);
        }
        return true;
    }

    public function setSessionUser(int $name): void
    {
        $this->sessionStart();
        $_SESSION['user_id'] = $name;
    }

    public function getCurrentUser(): ?User
    {
        if (!$this->checkSessionUser()) {
            return null;
        }
        // можно было чутка подумать и додуматься до этого..а я даже не утруждалась...
        // и сделала попроще...лишь бы сделать, да?
        // да и до возвращения объекта тоже можно было додуматься, если бы поднапрягла мозги...
        $this->sessionStart();
        $userId = $_SESSION['user_id'];
        return User::getById($userId);
    }

    public function checkSessionUser(): bool
    {
        $this->sessionStart();
        return isset($_SESSION['user_id']);
    }

    public function logout()
    {
        $this->sessionStart();
        unset($_SESSION['user_id']);
        session_destroy();
    }

    private function sessionStart()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}