<?php

namespace app;

use database\Db;
abstract class Model
{
    public $db;
    public function __construct()
    {
        $this->db = new Db;
    }
}