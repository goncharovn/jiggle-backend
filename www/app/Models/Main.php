<?php

namespace app\Models;

use app\Model;

class Main extends Model
{
    public function getProducts()
    {
        $result = $this->db->row('SELECT products.title, products.price, products.id, img.img_name FROM products INNER JOIN img ON products.id = img.product_id');
        return $result;
    }

    public function getProduct($id)
    {
        $result = $this->db->row('SELECT products.title, products.price, products.id, products.description, img.img_name FROM products INNER JOIN img ON products.id = img.product_id WHERE products.id = ' . $id);
        return $result;
    }
}