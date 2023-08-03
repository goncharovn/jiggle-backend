<?php

namespace app\Models;

use app\Model;

class ProductsModel extends Model
{
    public function getProducts(): bool|array
    {
        return $this->db->fetchAll("
            SELECT products.title, products.price, products.id, img.img_name 
            FROM products 
            INNER JOIN img
            ON products.id = img.product_id
        ");
    }

    public function getProduct($id): bool|array
    {
        return $this->db->fetchAll("
            SELECT products.title, products.price, products.id, products.description, img.img_name 
            FROM products 
            INNER JOIN img 
            ON products.id = img.product_id 
            WHERE products.id = :id
            ", ['id' => $id])[0];
    }
}