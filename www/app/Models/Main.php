<?php

namespace app\Models;

use app\Model;

class Main extends Model
{
    public function getProducts()
    {
        $result = $this->db->row('SELECT title, price FROM products');
        return $result;
    }
}