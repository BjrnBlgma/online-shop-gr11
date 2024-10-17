<?php
namespace Model;
use PDO;

class Model
{
    protected PDO $pdo;

    public function getConnectPdo()
    {
        return $this->pdo =  new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
    }
}