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
            SELECT products.id, products.title, products.price,  products.description, products.quantity, img.img_name 
            FROM products 
            INNER JOIN img 
            ON products.id = img.product_id 
            WHERE products.id = :id
            ",
            [
                'id' => $id
            ]
        )[0];
    }

    public function getProductsInBasket($productsIdsInBasket)
    {
        if (!empty($productsIdsInBasket)) {
            return $this->db->fetchAll("
                SELECT products.*, img.img_name 
                FROM products LEFT JOIN img ON products.id = img.product_id 
                WHERE products.id IN ($productsIdsInBasket)
            ");
        }
    }
}