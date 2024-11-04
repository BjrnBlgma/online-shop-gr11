<?php
namespace Controller;
use Request\LoginRequest;
use Service\Authentication\AuthSessionService;

class LoginController
{
    private AuthSessionService $authentication;
    public function __construct(){
        $this->authentication = new AuthSessionService();
    }
    public function getLoginForm()
    {
        require_once "./../View/login.php";
    }
    public function loginUser(LoginRequest $request)
    {
        $errors = $request->validate();

        if  (empty($errors)) {
            $login = $request->getLogin();
            $password = $request->getPassword();

            if ($this->authentication->login($login, $password)) {
                header('Location: /catalog');
            } else {
                    $errors['login'] = 'Incorrect email or password';
            }
        }
        require_once "./../View/login.php";
    }

    public function logoutUser()
    {
        $this->authentication->logout();
        header('Location: /login');
        exit;
    }
}