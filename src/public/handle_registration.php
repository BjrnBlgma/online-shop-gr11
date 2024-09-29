<?php
$name = $_GET["name"];
$email = $_GET["email"];
$password = $_GET["psw"];
//$passRepeat = $_GET["psw-repeat"];

$pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
$pdo->exec("INSERT INTO users (name, email, password) VALUES ('{$name}', '{$email}', '{$password}')");

$res = $pdo->query("SELECT * FROM users ORDER BY id DESC LIMIT 1 ");
print_r($res->fetch());