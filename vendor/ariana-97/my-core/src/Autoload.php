<?php

namespace Core;

class Autoload
{
    public static function registrate(string $rootPath)
    {
        $autoloaderCommon = function(string $name) use ($rootPath) {
            $name = str_replace('\\', '/', $name);
            $path = $rootPath . $name . ".php";
            if (file_exists($path)) {
                require_once $path;
                return true;
            }
            return false;
        };
        spl_autoload_register($autoloaderCommon);
    }
}