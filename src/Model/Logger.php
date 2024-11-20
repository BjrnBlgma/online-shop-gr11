<?php
namespace Ariana\FirstProject\Model;
use Core\Model;

class Logger extends Model
{
    public static function createLog(string $message, string $file, string $line)
    {
        $stmt = self::getPdo()->prepare("INSERT INTO loggers (message, file, line) VALUES (:message, :file, :line)");
        $stmt->execute(['message' => $message, 'file' => $file, 'line'=> $line]);
    }
}