<?php
namespace Session;

class Session
{
    public static function start()
    {
        session_start();
    }

    public static function setSessionUser($name)
    {
        $_SESSION['user_id'] = $name;
    }

    public static function getSessionUser() {
        if (isset($_SESSION['user_id'])) {
            return $_SESSION['user_id'];
        }
        return $_SESSION['user_id'];
    }

    public static function checkSessionUser()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
    }

    public static function logout()
    {
        unset($_SESSION['user_id']);
    }

    public static function destroySession()
    {
        session_destroy();
    }
}