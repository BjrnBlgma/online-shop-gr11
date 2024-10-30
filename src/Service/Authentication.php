<?php
namespace Service;

class Authentication
{
    public function start()
    {
        session_start();
    }

    public function setSessionUser($name)
    {
        $_SESSION['user_id'] = $name;
    }

    public function getSessionUser()
    {
        return $_SESSION['user_id'];
    }

    public function checkSessionUser()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
    }

    public function destroySession()
    {
        session_destroy();
    }
}