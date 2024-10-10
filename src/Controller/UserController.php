<?php
class UserController
{
    public function getRegistrateForm()
    {
        require_once "./../View/registrate.php";
    }

    public function registrate()
    {
        $errors = $this->validateRegister();

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $hash = password_hash($password, PASSWORD_DEFAULT);

            try {
                require_once "./../Model/User.php";
                $user = new User();
                $user->createUser($name, $email, $hash);

                header('Location: /login');
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage();
                //die();
            }
        }

        require_once "./../View/registrate.php";
    }


    private function validateRegister(): array
    {
        $errors = [];

        if (isset($_POST['name'])) {
            $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
            if (empty($name)){
                $errors['name'] = "Имя не должно быть пустым";
            } elseif (strlen($name) < 3 || strlen($name) > 20) {
                $errors['name'] = "Имя должно содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я]+$/u", $name)) {
                $errors['name'] = "Имя может содержать только буквы";
            }
        }else{
            $errors ['name'] = "Поле name должно быть заполнено";
        }


        if (isset($_POST['email'])) {
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

            require_once "./../Model/User.php";
            $user = new User();
            $isCorrectEmail = $user->getByEmail($email); //свободна ли почта или уже занята
            if (empty($email)) {
                $errors ['email'] = "Почта не должна быть пустой";
            }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors ['email'] = "Введите корректный email-адрес!";
            }elseif ( (strlen($email) < 3)||(strlen($email) > 60) ){
                $errors ['email'] = "email-адрес должен содержать не меньше 3 символов и не больше 60 символов";
            }elseif ($isCorrectEmail) {
                $errors['email'] = "email уже занят!";
            }
        }else{
            $errors ['email'] = "Поле email должно быть заполнено";
        }


        if (isset($_POST['password'])) {
            $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
            if (empty($password)) {
                $errors ['password'] = "Пароль не должен быть пустым";
            }elseif (strlen($password) < 8 || strlen($password) > 20) {
                $errors ['password'] = "Пароль должен быть не менее 8 символов и не более 20 символов";
            }
        }else{
            $errors ['password'] = "Поле password должно быть заполнено";
        }


        if (isset($_POST['psw-repeat'])) {
            $passRepeat = htmlspecialchars($_POST['psw-repeat'], ENT_QUOTES, 'UTF-8');
            $password = $_POST['password'];
            if (empty($passRepeat)) {
                $errors ['psw-repeat'] = "Поле не должно быть пустым";
            }elseif ($passRepeat != $password) {
                $errors ['psw-repeat'] = "Пароли не совпадают"; //Passwords do not match"
            }
        }else {
            $errors ['psw-repeat'] = "Поле repeat password должно быть заполнено";
        }

        return $errors;
    }

}