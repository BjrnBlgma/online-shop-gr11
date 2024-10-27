<?php
namespace Controller;
use Model\User;
use Request\LoginRequest;
use Service\Session;

class LoginController
{
    public function getLoginForm()
    {
        require_once "./../View/login.php";
    }
    public function loginUser(LoginRequest $request)
    {
        $errors = $request->validate();

        if  (empty($errors)) {
            try {
                $login = $request->getLogin();
                $password = $request->getPassword();


                $data = User::getByEmail($login);

                if (empty($data)) {
                    $errors['login'] = 'Incorrect email or password';
                } else {
                    $passFromDb = $data->getPassword();
                    if (password_verify($password, $passFromDb)) {
                        Session::start();
                        $userSession = $data->getId();
                        Session::setSessionUser($userSession);

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
        Session::start();
        Session::logout();
        Session::destroySession();
        header('Location: /login');
        exit;
    }
}