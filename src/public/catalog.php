<?php
session_start();
if (!isset($_SESSION['user_id'])){
    header('Location: /get_login.php');
}
//echo 'here is Catalog';
$pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

$prodeucts = [];
?>