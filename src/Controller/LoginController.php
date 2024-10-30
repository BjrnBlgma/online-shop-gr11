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
            try {
                $login = $request->getLogin();
                $password = $request->getPassword();


                $data = User::getByEmail($login);

                if (empty($data)) {
                    $errors['login'] = 'Incorrect email or password';
                } else {
                    $passFromDb = $data->getPassword();
                    if (password_verify($password, $passFromDb)) {
                        $this->authentication->start();
                        $userSession = $data->getId();
                        $this->authentication->setSessionUser($userSession);

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
        $this->authentication->start();
        $this->authentication->logout();
        $this->authentication->destroySession();
        header('Location: /login');
        exit;
    }
}