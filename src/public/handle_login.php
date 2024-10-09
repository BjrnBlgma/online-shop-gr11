<?php
require_once "./classes/Login.php";

$login = new Login();
$login->loginUser();

$errors = $login->loginUser();
require_once  './get_login.php';
?>