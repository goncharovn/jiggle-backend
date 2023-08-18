<?php

namespace app\Models;

use database\Db;

class ProductModel
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $hash;
    private string $resetKey;
    private bool $isTwoFactorAuthEnabled;
    private string $twoFactorAuthCode;
    private string $newEmail;

    public static function getProducts(): bool|array
    {
        return Db::fetchAll(
            "SELECT DISTINCT 
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
                products_images pi ON pv.id = pi.product_variant_id"
        );
    }

    public static function getProduct($productId, $productColor, $productSize): bool|array
    {
        return Db::fetchAll(
            "SELECT
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
                (s.name = :product_size OR :product_size IS NULL)",
            [
                'product_id' => $productId,
                'product_color' => $productColor,
                'product_size' => $productSize,
            ]
        )[0];
    }

    public static function getAvailableColors($productId, $productSize): bool|array
    {
        return Db::fetchAll(
            "SELECT DISTINCT 
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
                (s.name = :product_size OR :product_size IS NULL )",
            [
                'product_id' => $productId,
                'product_size' => $productSize,
            ]
        );
    }

    public static function getAvailableSizes($productId, $productColor): bool|array
    {
        return Db::fetchAll(
            "SELECT DISTINCT 
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
                (c.name = :product_color OR c.id = p.default_color_id)",
            [
                'product_id' => $productId,
                'product_color' => $productColor,
            ]
        );
    }

    public static function getDefaultProductColor($productId)
    {
        return Db::fetchAll(
            "SELECT 
                c.name
            FROM 
                products p
            JOIN 
                colors c ON p.default_color_id = c.id
            WHERE 
                p.id = :product_id",
            [
                'product_id' => $productId,
            ]
        )[0]["name"];
    }

    public static function getProductsInBasket($productsIdsInBasket)
    {
        if (!empty($productsIdsInBasket)) {
            return Db::fetchAll(
                "SELECT 
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
                    pv.id IN ($productsIdsInBasket)"
            );
        }
    }
}