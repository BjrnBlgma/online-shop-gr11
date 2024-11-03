<?php
namespace Controller;
use Model\User;
use Request\LoginRequest;
use Service\Authentication;

class LoginController
{
    private Authentication $authentication;
    public function __construct(){
        $this->authentication = new Authentication();
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

            $data = User::getByEmail($login);
            if ($this->authentication->login($login, $password)) {
                $userSession = $data->getId();
                $this->authentication->setSessionUser($userSession);

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