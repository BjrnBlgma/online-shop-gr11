<?php
require_once __DIR__ . "/classes/User.php";

$user = new User();
$user->register();
require_once "./get_registration.php";
?>