<?php

namespace Service\Logger;

use Model\Logger;

class LoggerDbService implements LoggerServiceInterface
{
    public function error(string $message, array $data = [])
    {
        $error = $data['message'];
        $file = $data['file'];
        $line = $data['line'];
        Logger::createLog($error, $file, $line);
    }


    public function info(string $message, array $data = [])
    {

    }


    public function warning(string $message, array $data = [])
    {

    }
}