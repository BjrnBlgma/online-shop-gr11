<?php
class User
{
    public function register()
    {
        $errors = $this->validate();

        if (empty($errors)) {
            $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
            $passRepeat = htmlspecialchars($_POST['psw-repeat'], ENT_QUOTES, 'UTF-8');

            try {
                $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
                $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);



                #$stmt = $pdo->prepare("SELECT * FROM users WHERE email =  :email");
                #$stmt->execute(['email' => $email]);
                #print_r($stmt->fetch());
                $result = 'Вы успешно зарегестрировались!';

                header('Location: /login');
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage();
                //die();
            }
        }
    }



    private function validate(): array
    {
        $errors = [];
        if (isset($_POST['name'])) {
            $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
            if (empty($name)){
                $errors ['name'] = "Имя не должно быть пустым";
            }elseif (strlen($name) < 2){
                $errors ['name'] = "Слишком короткое имя";
            }elseif (strlen($name) > 20){
                $errors ['name'] = "Слишком длинное имя";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я]+$/u", $name)) {
                $errors ['name'] = "Имя может сожержать только буквы и пробелы";
            }
        }else{
            $errors ['name'] = "Поле name должно быть заполнено";
        }


        if (isset($_POST['email'])) {
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
            if (empty($email)) {
                $errors ['email'] = "Почта не должна быть пустой";
            }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors ['email'] = "Введите корректный email-адрес!";
            }elseif (strlen($email) < 3 && strlen($email) > 60) {
                $errors ['email'] = "email-адрес должен содержать не меньше 3 символов и не больше 60 символов";
            }
        }else{
            $errors ['email'] = "Поле email должно быть заполнено";
        }


        if (isset($_POST['password'])) {
            $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
            if (empty($password)) {
                $errors ['password'] = "Пароль не должен быть пустым";
            }elseif (strlen($password) < 8 && strlen($password) > 20) {
                $errors ['password'] = "Пароль должен быть не менее 8 символов и не более 20 символов";
            }
        }else{
            $errors ['password'] = "Поле password должно быть заполнено";
        }


        if (isset($_POST['psw-repeat'])) {
            $passRepeat = htmlspecialchars($_POST['psw-repeat'], ENT_QUOTES, 'UTF-8');
            if (empty($passRepeat)) {
                $errors ['psw-repeat'] = "Пароль не должен быть пустым";
            }elseif ($passRepeat != $password) {
                $errors ['psw-repeat'] = "Пароли не совпадают"; //Passwords do not match"
            }
        }else {
            $errors ['psw-repeat'] = "Поле repeat password должно быть заполнено";
        }
        return $errors;
    }
}