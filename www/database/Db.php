<?php

namespace database;

use PDO;

class Db
{
    private PDO $db;

    public function __construct()
    {
        $config = require '../config/app/db_config.php';
        $this->db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['user'], $config['password']);
    }

    public function executeQuery($sql, $params = []): bool|\PDOStatement
    {
        $statement = $this->db->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $param => $val) {
                $statement->bindValue(':' . $param, $val);
            }
        }

        $statement->execute();

        return $statement;
    }

    public function fetchAll($sql, $params = []): bool|array
    {
        return $this->executeQuery($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchColumn($sql, $params = [])
    {
        return $this->executeQuery($sql, $params)->fetchColumn();
    }
}