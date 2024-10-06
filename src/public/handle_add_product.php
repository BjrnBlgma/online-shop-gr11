<?php
session_start();
if (!isset($_SESSION['user_id'])){
    header('Location: /login');
} else{
    $user_id = $_SESSION['user_id'];
}

$errors = [];
if (isset($_POST['product_id'])) {
    $product_id = htmlspecialchars($_POST['product_id'], ENT_QUOTES, 'UTF-8');
} else {
    $errors['product_id'] = 'Выберите продкут';
}

if (isset($_POST['amount'])) {
    $amount = htmlspecialchars($_POST['amount'], ENT_QUOTES, 'UTF-8');
} else {
    $errors['amount'] = 'Выберите количество товара';
}


if (empty($errors)) {
    $user_id = $_SESSION['user_id'];
    $product_id = htmlspecialchars($_POST['product_id'], ENT_QUOTES, 'UTF-8');
    $amount = htmlspecialchars($_POST['amount'], ENT_QUOTES, 'UTF-8');

    try {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);



        /*$stmt = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        print_r($stmt->fetchAll());*/

        //header('Location: /cart');
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage();
        //die();
    }
}

require_once 'get_add_product.php';

?>