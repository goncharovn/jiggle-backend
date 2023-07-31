<?php

namespace app\Models;

use app\Model;

class Basket extends Model
{
    public function getBasketData()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!empty($_SESSION['basket'])) {
            $productIds = implode(',', array_map('intval', $_SESSION['basket']));
            return $this->db->row("SELECT products.*, img.img_name FROM products LEFT JOIN img ON products.id = img.product_id WHERE products.id IN ($productIds)");
        }

        return [];
    }
}