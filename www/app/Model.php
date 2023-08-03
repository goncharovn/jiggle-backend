<?php

namespace app;

use database\Db;

abstract class Model
{
    public Db $db;

    public function __construct()
    {
        $this->db = new Db;
    }
}