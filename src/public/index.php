<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/login'){
    if ($requestMethod === 'GET'){
        require_once './get_login.php';
    } elseif ($requestMethod === 'POST'){
        require_once './handle_login.php';
    }
}

