<?php
namespace Ariana\FirstProject\Controller;
use Ariana\FirstProject\Request\LoginRequest;
use Core\Authentication\AuthServiceInterface;

class LoginController
{
    private AuthServiceInterface $authentication;

    public function __construct(AuthServiceInterface $authentication)
    {
        $this->authentication = $authentication;
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