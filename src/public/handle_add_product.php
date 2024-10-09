<?php
session_start(); // session_start должен быть в начале

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}
require_once __DIR__ . "/classes/ProductToAdd.php";


$product = new ProductToAdd();
$product->addProductToCart();
require_once 'get_add_product.php';
?>