<?php
require_once __DIR__ . "./classes/Login.php";

$login = new Login();
$login->loginUser();
require_once  './get_login.php';
?>