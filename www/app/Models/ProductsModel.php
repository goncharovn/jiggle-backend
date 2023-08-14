<?php

namespace app\Models;

use app\Model;

class ProductsModel extends Model
{
    public function getProducts(): bool|array
    {
        return $this->db->fetchAll("
            SELECT DISTINCT 
                p.*,
                pi.image_name
            FROM
                products p
            JOIN
                products_variants pv ON p.id = pv.product_id
            JOIN
                colors c ON 
                    pv.color_id = c.id AND 
                    p.default_color_id = c.id
            JOIN
                sizes s ON pv.size_id = s.id
            LEFT JOIN
                products_images pi ON pv.id = pi.product_variant_id
        ");
    }

    public function getProduct($productId, $productColor, $productSize): bool|array
    {
        return $this->db->fetchAll("
            SELECT
                p.*, 
                pi.image_name,
                c.name AS color,
                pv.quantity,
                CASE
                    WHEN :product_size IS NULL THEN NULL
                    ELSE pv.id
                END AS variant_id,
                CASE
                    WHEN :product_size IS NULL THEN NULL
                    ELSE s.name
                END AS size
            FROM 
                products p 
            JOIN
                products_variants pv ON p.id = pv.product_id
            LEFT JOIN
                products_images pi ON pv.id = pi.product_variant_id
            JOIN
                colors c ON pv.color_id = c.id 
            JOIN
                sizes s ON pv.size_id = s.id 
            WHERE 
                p.id = :product_id AND
                c.name = :product_color AND
                (s.name = :product_size OR :product_size IS NULL)
        ",
            [
                'product_id' => $productId,
                'product_color' => $productColor,
                'product_size' => $productSize
            ]
        )[0];
    }

    public function getAvailableColors($productId, $productSize): bool|array
    {
        return $this->db->fetchAll("
            SELECT DISTINCT 
                c.*
            FROM
                products p
            JOIN
                products_variants pv ON p.id = pv.product_id
            JOIN
                colors c ON pv.color_id = c.id
            JOIN
                sizes s ON pv.size_id = s.id
            WHERE
                p.id = :product_id AND
                (s.name = :product_size OR :product_size IS NULL )
        ",
            [
                'product_id' => $productId,
                'product_size' => $productSize
            ]
        );
    }

    public function getAvailableSizes($productId, $productColor): bool|array
    {
        return $this->db->fetchAll("
            SELECT DISTINCT 
                s.name
            FROM
                products p
            JOIN
                products_variants pv ON p.id = pv.product_id
            JOIN
                sizes s ON pv.size_id = s.id
            JOIN
                colors c ON pv.color_id = c.id
            WHERE
                p.id = :product_id AND
                (c.name = :product_color OR c.id = p.default_color_id)
        ",
            [
                'product_id' => $productId,
                'product_color' => $productColor
            ]
        );
    }

    public function getDefaultProductColor($productId)
    {
        return $this->db->fetchAll("
            SELECT 
                c.name
            FROM 
                products p
            JOIN 
                colors c ON p.default_color_id = c.id
            WHERE 
                p.id = :product_id
        ",
            [
                'product_id' => $productId
            ]
        )[0]["name"];
    }

    public function getProductsInBasket($productsIdsInBasket)
    {
        if (!empty($productsIdsInBasket)) {
            return $this->db->fetchAll("
                SELECT 
                    p.*, 
                    pi.image_name,
                    pv.id AS variant_id,
                    c.name AS color,
                    s.name AS size
                FROM 
                    products p 
                JOIN
                    products_variants pv ON p.id = pv.product_id
                LEFT JOIN
                    products_images pi ON pv.id = pi.product_variant_id
                JOIN
                    sizes s ON pv.size_id = s.id
                JOIN
                    colors c ON pv.color_id = c.id
                WHERE 
                    pv.id IN ($productsIdsInBasket)
            ");
        }
    }
}