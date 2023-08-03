<?php

namespace app\Models;

use app\Model;

class BasketModel extends Model
{
    public function getBasketData($productsIdsInBasket)
    {
        if (!empty($productsIdsInBasket)) {
            return $this->db->fetchAll("
                SELECT products.*, img.img_name 
                FROM products LEFT JOIN img ON products.id = img.product_id 
                WHERE products.id IN ($productsIdsInBasket)
            ");
        }
    }

    public function getTotalBasketCost($productsIdsInBasket)
    {
        if (!empty($productsIdsInBasket)) {
            return $this->db->fetchAll("
                SELECT SUM(price) AS total_cost 
                FROM products 
                WHERE id IN ($productsIdsInBasket)
            ")[0]['total_cost'];
        }
    }
}