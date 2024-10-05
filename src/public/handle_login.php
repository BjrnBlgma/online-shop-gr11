<?php

$errors = [];
if (isset($_POST['login'])) {
    $login = htmlspecialchars($_POST['login'], ENT_QUOTES, 'UTF-8');
} else {
    $errors['login'] = 'Login is required';
}

if (isset($_POST['password'])) {
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
} else {
    $errors['password'] = 'Password is required';
}


if  (empty($errors)){
    try {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :login');
        $stmt->execute(['login' => $login]);

        $data = $stmt->fetch();

        if ($data === false) {
            $errors['login'] = 'Incorrect email or password';
        } else{
            $passFromDb = $data['password'];
            if (password_verify($password, $passFromDb)) {
                //setcookie('user_id', $data['id']);
                session_start();
                $_SESSION['user_id'] = $data['id'];
                header('Location: /catalog');
            } else{
                $errors['login'] = 'Incorrect email or password';
            }
        }
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage();
        //die();
    }
}


require_once  './get_login.php';
?>