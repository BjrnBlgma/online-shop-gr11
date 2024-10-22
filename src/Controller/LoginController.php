<?php
namespace Controller;
use Model\User;

class LoginController
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }
    public function getLoginForm()
    {
        require_once "./../View/login.php";
    }
    public function loginUser()
    {
        $errors = $this->validateLogin();

        if  (empty($errors)) {
            try {
                $login = htmlspecialchars($_POST['login'], ENT_QUOTES, 'UTF-8');
                $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');


                $data = $this->user->getByEmail($login);

                if (empty($data)) {
                    $errors['login'] = 'Incorrect email or password';
                } else {
                    $passFromDb = $data->getPassword();
                    if (password_verify($password, $passFromDb)) {
                        session_start();
                        $_SESSION['user_id'] = $data->getId();

                        header('Location: /catalog');
                    } else {
                        $errors['login'] = 'Incorrect email or password';
                    }
                }
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage();
                //die();
            }
        }

        require_once "./../View/login.php";
    }

    public function logoutUser()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /login');
        exit;
    }

    private function validateLogin(): array
    {
        $errors = [];
        if (isset($_POST['login'])) {
            $login = htmlspecialchars($_POST['login'], ENT_QUOTES, 'UTF-8');
        } else {
            $errors['login'] = 'Incorrect email or password';
        }

        if (isset($_POST['password'])) {
            $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
        } else {
            $errors['login'] = 'Incorrect email or password';
        }

        return $errors;
    }
}