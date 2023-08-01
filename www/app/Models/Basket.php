<?php

namespace app\Models;

use app\Model;

class Basket extends Model
{
    public function getBasketData()
    {
        session_start();

        if (!empty($_SESSION['basket'])) {
            $productIds = implode(',', array_map('intval', $_SESSION['basket']));
            return $this->db->row("SELECT products.*, img.img_name FROM products LEFT JOIN img ON products.id = img.product_id WHERE products.id IN ($productIds)");
        }

        return [];
    }

    public function getTotalBasketCost()
    {
        session_start();

        $basketData = $_SESSION['basket'] ?? [];

        if (!empty($basketData)) {
            $productIdsString = implode(',', $basketData);

            $result = $this->db->row("SELECT SUM(price) AS total_cost FROM products WHERE id IN ($productIdsString)");

            return $result[0]['total_cost'];
        }

        return 0;
    }
}