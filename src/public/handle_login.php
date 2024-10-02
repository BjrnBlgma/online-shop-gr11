<?php

$errors = [];
if (isset($_POST['login'])) {
    $login = $_POST['login'];
} else {
    $errors['login'] = 'Login is required';
}

if (isset($_POST['password'])) {
    $password = $_POST['password'];
} else {
    $errors['password'] = 'Password is required';
}


if  (empty($errors)){
    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :login');
    $stmt->execute(['login' => $login]);

    $data = $stmt->fetch();

    if ($data === false) {
        $errors['login'] = 'Incorrect email or password';
    } else{
        $passFromDb = $data['password'];
        if (password_verify($password, $passFromDb)) {
            setcookie('user_id', $data['id']);
            header('Location: catalog.php');
        } else{
            $errors['login'] = 'Incorrect email or password';
        }
    }
}


require_once  './get_login.php';
?>