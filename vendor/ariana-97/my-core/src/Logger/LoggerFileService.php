<?php
namespace Service\Logger;

class LoggerFileService implements LoggerServiceInterface
{
    public function error(string $message, array $data = [])
    {
        $file = './../Storage/Log/errors.txt';
        date_default_timezone_set('Asia/Irkutsk');
        $time = 'Дата: '  . date('d.m.Y H:i:s') . "\n";

        file_put_contents($file, $message . "\n", FILE_APPEND);
        foreach ($data as $key => $value) {
            file_put_contents($file, "{$key}: {$value}\n", FILE_APPEND);
        }
//        file_put_contents($file, implode("\n", $data), FILE_APPEND | LOCK_EX);
        file_put_contents($file, $time . "\n", FILE_APPEND);
    }


    public function info(string $message, array $data = [])
    {
        $file = './../Storage/Log/info.txt';
    }


    public function warning(string $message, array $data = [])
    {
        $file = './../Storage/Log/warning.txt';
    }
}