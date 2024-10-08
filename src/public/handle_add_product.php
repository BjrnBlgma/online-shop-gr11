<?php
if (!isset($_SESSION['user_id'])){
    header('Location: /login');
}

$errors = [];
if (isset($_POST['product_id'])) {
    $productId = htmlspecialchars($_POST['product_id'], ENT_QUOTES, 'UTF-8');
    if (empty($productId)) {
        $errors['product'] = "ID товара не должно быть пустым";
    }elseif (!is_numeric($productId)) {
        $errors['product'] = "Поле ID товара должно содержать только цифры!";
    }elseif ($productId <= 0){
        $errors['product'] = "Поле ID товара не должно содержать отрицательные значения";
    }
} /*else {
    $errors['product_id'] = 'Выберите продкут';
}*/

if (isset($_POST['amount'])) {
    $amount = htmlspecialchars($_POST['amount'], ENT_QUOTES, 'UTF-8');
    if (empty($amount)) {
        $errors['amount'] = "Выберите количество товара";
    }elseif (!is_numeric($amount)) {
        $errors['amount'] = "Поле количества товара должно содержать только цифры!";
    }elseif ($amount <= 0){
        $errors['amount'] = "Поле количества товара не должно быть отрицательным";
    }
} /*else {
    $errors['amount'] = 'Выберите количество товара';
}*/


if (empty($errors)) {
    session_start();
    $productId = htmlspecialchars($_POST['product_id'], ENT_QUOTES, 'UTF-8');
    $amount = htmlspecialchars($_POST['amount'], ENT_QUOTES, 'UTF-8');
    $userId = $_SESSION['user_id'];

    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

    $stmt = $pdo->prepare('SELECT id FROM products WHERE id = :productID');
    $stmt->execute(['productID' => $productId]);
    $data = $stmt->fetch();

    if ($data === false){
        $errors['product'] = "Введите корректный ID товара";
    } else {
        try {

            $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
            $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);

            header('Location: /cart');
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
            //die();
        }
    }




        /*$stmt = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        print_r($stmt->fetchAll());*/



}

require_once 'get_add_product.php';

?>