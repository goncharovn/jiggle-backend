<?php

namespace jiggle\database;

use PDO;

class Db
{
    private static ?Db $instance = null;
    private static PDO $db;

    private function __construct()
    {
        $config = require '../config/app/db_config.php';
        self::$db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['user'], $config['password']);
    }

    public static function getInstance(): Db
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function executeQuery($sql, $params = []): bool|\PDOStatement
    {
        $statement = self::$db->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $param => $val) {
                $statement->bindValue(':' . $param, $val);
            }
        }

        $statement->execute();

        return $statement;
    }

    public static function fetchAll($sql, $params = []): bool|array
    {
        return self::executeQuery($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function fetchColumn($sql, $params = [])
    {
        return self::executeQuery($sql, $params)->fetchColumn();
    }
}