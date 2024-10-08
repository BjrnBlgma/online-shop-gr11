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
    if ($requestMethod === 'GET'){
        require_once './catalog.php';
    } else{
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
} elseif ($requestUri === '/add'){
    if ($requestMethod === 'GET'){
        require_once './get_add_product.php';
    } elseif ($requestMethod === 'POST'){
        require_once './handle_add_product.php';
    }
} /*elseif ($requestUri === '/logout') {
    if ($requestMethod === 'GET') {
        require_once './logout.php';
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
}*/ elseif ($requestUri === '/cart') {
    require_once './cart.php';
}
else{
    http_response_code(404);
    require_once '404.php';
}
