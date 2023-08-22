<?php

namespace jiggle\app\Models;

use jiggle\database\Db;

class ProductModel
{
    private int $id;
    private string $title;
    private int $price;
    private string $description;
    private int $defaultColorId;
    private string $imageName;
    private string $color;
    private string $size;
    private int $quantity;
    private int|null $variantId;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDefaultColorId(): int
    {
        return $this->defaultColorId;
    }

    public function getImageName(): string
    {
        return $this->imageName;
    }


    public function getColor(): string
    {
        return $this->color;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getVariantId(): ?int
    {
        return $this->variantId ?? null;
    }

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

    public static function getProduct($productId, $productColor, $productSize): self
    {
        $result = Db::fetchAll(
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

        $product = new self();
        $product->id = $result['id'] ?? '';
        $product->title = $result['title'] ?? '';
        $product->price = $result['price'] ?? '';
        $product->description = $result['description'] ?? '';
        $product->defaultColorId = $result['default_color_id'] ?? '';
        $product->imageName = $result['image_name'] ?? '';
        $product->color = $result['color'] ?? '';
        $product->size = $result['size'] ?? '';
        $product->quantity = $result['quantity'] ?? '';
        $product->variantId = $result['variant_id'] ?? null;

        return $product;
    }

    public function getAvailableColors($productSize): bool|array
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
                'product_id' => $this->id,
                'product_size' => $productSize,
            ]
        );
    }

    public function getAvailableSizes($productColor): bool|array
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
                'product_id' => $this->id,
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

    public static function getProductsInBasket($productsIdsInBasket): bool|array
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

        return false;
    }
}