<?php
namespace Ariana\FirstProject\Controller;
use Ariana\FirstProject\Request\RegistrateRequest;
use Ariana\FirstProject\Model\User;

class UserController
{
    public function getRegistrateForm()
    {
        require_once "./../View/registrate.php";
    }

    public function registrate(RegistrateRequest $request)
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $name = $request->getName();
            $email = $request->getEmail();
            $password = $request->getPassword();
            $hash = password_hash($password, PASSWORD_DEFAULT);

            User::createUser($name, $email, $hash);
            header('Location: /login');
        }

        require_once "./../View/registrate.php";
    }
}