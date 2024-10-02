<?php
$res = $_POST;
function validate($res): array
{
    $errors = [];
    if (isset($_POST['name'])) {
        $name = $_POST['name'];

        if (empty($name)){
            $errors ['name'] = "Имя не должно быть пустым";
        }elseif (strlen($name) < 2){
            $errors ['name'] = "Имя должно быть не менее 2 символов";
        }elseif (gettype($name) != "string") {
            $errors ['name'] = "Имя должно состоять из букв";
        }
    }/*else{
        $errors ['name'] = "Поле name должно быть заполнено";
    }*/

    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        if (empty($email)) {
            $errors ['email'] = "Почта не должна быть пустой";
        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors ['email'] = "Введите корректный email-адрес!";
        }
    }/*else{
        $errors ['email'] = "Поле email должно быть заполнено";
    }*/

    if (isset($_POST['password'])) {
        $password = $_POST['password'];

        if (empty($password)) {
            $errors ['password'] = "Пароль не должен быть пустым";
        }elseif (strlen($password) < 8 && strlen($password) > 20) {
            $errors ['password'] = "Пароль должен быть не менее 8 символов и не более 20 символов";
        }
    }/*else{
        $errors ['password'] = "Поле password должно быть заполнено";
    }*/

    if (isset($_POST['psw-repeat'])) {
        $passRepeat = $_POST['psw-repeat'];

        if (empty($passRepeat)) {
            $errors ['psw-repeat'] = "Пароль не должен быть пустым";
        }elseif ($passRepeat != $password) {
            $errors ['psw-repeat'] = "Пароли не совпадают"; //Passwords do not match"
        }
    }/*else {
        $errors ['psw-repeat'] = "Поле repeat password должно быть заполнено";
    }*/

    return $errors;
}

$errors = validate($res);

if (empty($errors)) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passRepeat = $_POST["psw-repeat"];

    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);

//$pdo->exec("INSERT INTO users (name, email, password) VALUES ('$name', '{$email}', '{$password}')");

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email =  :email");
    $stmt->execute(['email' => $email]);
    //print_r($stmt->fetch());
    $result = 'Вы успешно зарегестрировались!';
}

require_once "./get_registration.php";
?>