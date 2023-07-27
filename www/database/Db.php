<?php

namespace database;

use PDO;

class Db
{
    public function __construct()
    {
        $config = require '../config/db.php';
        $this->db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['user'], $config['password']);
    }

    public function query($sql, $params = []): bool|\PDOStatement
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

    public function row($sql, $params = []): bool|array
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }
}