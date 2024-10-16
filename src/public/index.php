<?php
use Core\App;

$autoloaderCommon = function(string $name) {
    $name = str_replace('\\', '/', $name);
    $path = "./../$name.php";
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    return false;
};

spl_autoload_register($autoloaderCommon);

$app = new App();
$app->run();

