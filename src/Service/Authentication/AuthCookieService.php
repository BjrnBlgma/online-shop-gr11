<?php

namespace Service\Authentication;

use Model\User;

class AuthCookieService implements AuthServiceInterface
{
    public function login(string $login, string $password)
    {
        $data = User::getByEmail($login);
        if (empty($data) and !password_verify($password, $data->getPassword())) {
            return false;
        }
        $this->sessionStart();
        $_COOKIE['user_id'] = $data->getId();
        return true;
    }

    public function getCurrentUser(): ?User
    {
        if (!$this->checkSessionUser()){
            return null;
        }
        $this->sessionStart();
        $userId = $_COOKIE['user_id'];
        return User::getById($userId);
    }

    public function checkSessionUser(): bool
    {
        $this->sessionStart();
        return isset($_COOKIE['user_id']);
    }

    public function logout()
    {
        $this->sessionStart();
        unset($_COOKIE['user_id']);
        session_destroy();
    }

    private function sessionStart()
    {
        if (session_status() !== PHP_SESSION_NONE) {
            session_start();
        }
    }
}