<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/login'){
    if ($requestMethod === 'GET'){
        require_once './get_login.php';
    } elseif ($requestMethod === 'POST'){
        require_once './handle_login.php';
    }
} elseif ($requestUri === '/register'){
    if ($requestMethod === 'GET'){
        require_once './get_registration.php';
    } elseif ($requestMethod === 'POST'){
        require_once './handle_registration.php';
    }
} elseif ($requestUri === '/catalog'){
    require_once './catalog.php';
} /*elseif ($requestUri = '/later'){
    require_once './catalog _later.php';
} */else{
    http_response_code(404);
    require_once '404.php';
}
