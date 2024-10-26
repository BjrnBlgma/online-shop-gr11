<?php
namespace Controller;
use Request\RegistrateRequest;
use Request\Request;

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

            try {
                User::createUser($name, $email, $hash);

                header('Location: /login');
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage();
                //die();
            }
        }

        require_once "./../View/registrate.php";
    }
}