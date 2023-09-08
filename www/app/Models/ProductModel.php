<?php

namespace jiggle\app\Models;

use jiggle\database\Db;

class ProductModel
{
    private int $id;
    private string $title;
    private int $price;
    private string $description;
    private string $imageName;
    private string $color;
    private string $size;
    private int $quantity;
    private int $basketQuantity;
    private ?int $variantId;

    public function getProductId(): int
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

    public function getBasketQuantity(): int
    {
        return $this->basketQuantity ?? 0;
    }

    public function setBasketQuantity(int $basketQuantity): void
    {
        $this->basketQuantity = $basketQuantity;
    }

    public function setVariantId(int $variantId): void
    {
        $this->variantId = $variantId;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function setImageName(string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public static function getProductsVariants(): bool|array
    {
        $queryResult = Db::fetchAll(
            'SELECT DISTINCT 
                p.*,
                pi.image_name
            FROM
                products_variants pv
            JOIN
                products p ON pv.product_id = p.id
            JOIN
                colors c ON 
                    pv.color_name = c.name
            JOIN
                sizes s ON pv.size_name = s.name
            LEFT JOIN
                products_images pi ON pv.product_id = pi.product_variant_id'
        );

        $productArray = [];
        foreach ($queryResult as $row) {
            $productArray[] = self::createProductVariant($row);
        }

        return $productArray;
    }

    public static function getProductVariant($variantId): self
    {
        $queryResult = Db::fetchAll(
            'SELECT
                pv.*,
                pv.id AS variant_id,
                p.*,
                pi.image_name
            FROM 
                products_variants pv 
            JOIN
                products p ON pv.product_id = p.id 
            LEFT JOIN 
                products_images pi ON pv.product_id = pi.product_id AND pv.color_name = pi.color_name
            WHERE 
                pv.id = :variant_id',
            [
                'variant_id' => $variantId
            ]
        )[0];

        return self::createProductVariant($queryResult);
    }

    public static function getProductById($productId): self
    {
        $queryResult = Db::fetchAll(
            'SELECT
                p.*
            FROM 
                products p
            WHERE 
                p.id = :product_id',
            [
                'product_id' => $productId,
            ]
        )[0];

        return self::createProduct($queryResult);
    }

    public function fetchImageName(): string
    {
        return Db::fetchColumn(
            'SELECT
                pi.image_name
            FROM 
                products_images pi
            JOIN
                products p ON pi.product_id = p.id
            JOIN
                colors c ON pi.color_name = c.name
            WHERE
                p.id = :product_id AND
                c.name = :color_name',
            [
                'product_id' => $this->id,
                'color_name' => $this->color,
            ]
        );
    }

    public function fetchQuantity(): string
    {
        $result = Db::fetchColumn(
            'SELECT
                pv.quantity
            FROM 
                products_variants pv
            JOIN
                products p ON pv.product_id = p.id
            JOIN
                colors c ON pv.color_name = c.name
            JOIN
                sizes s ON pv.size_name = s.name
            WHERE
                p.id = :product_id AND
                c.name = :color_name AND
                s.name = :size_name',
            [
                'product_id' => $this->id,
                'color_name' => $this->color,
                'size_name' => $this->size
            ]
        );

        return $result;
    }

    public function fetchVariantId(): string
    {
        $result = Db::fetchColumn(
            'SELECT
                pv.id AS variant_id
            FROM 
                products_variants pv
            JOIN
                products p ON pv.product_id = p.id
            JOIN
                colors c ON pv.color_name = c.name
            JOIN
                sizes s ON pv.size_name = s.name
            WHERE
                p.id = :product_id AND
                c.name = :color_name AND
                s.name = :size_name',
            [
                'product_id' => $this->id,
                'color_name' => $this->color,
                'size_name' => $this->size
            ]
        );

        return $result;
    }

    public static function getProducts(): bool|array
    {
        $queryResult = Db::fetchAll(
            'SELECT DISTINCT
                p.*,
                pi.image_name
            FROM
                products p
            JOIN
                products_images pi ON p.id = pi.product_id'
        );

        $productArray = [];
        foreach ($queryResult as $row) {
            $productArray[] = self::createProduct($row);
        }

        return $productArray;
    }

    public function getAvailableColors(): bool|array
    {
        return Db::fetchAll(
            'SELECT DISTINCT
                c.*
            FROM
                products_variants pv
            JOIN
                colors c ON pv.color_name = c.name
            WHERE
                product_id = :product_id',
            [
                'product_id' => $this->id
            ]
        );
    }

    public function getAvailableSizes(): bool|array
    {
        return Db::fetchAll(
            'SELECT DISTINCT
                s.*
            FROM
                products_variants pv
            JOIN
                sizes s ON pv.size_name = s.name
            WHERE
                product_id = :product_id',
            [
                'product_id' => $this->id
            ]
        );
    }

    public function getAvailableSizesByColor(): bool|array
    {
        return Db::fetchAll(
            'SELECT DISTINCT 
                s.name
            FROM
                products_variants pv
            JOIN
                products p ON pv.product_id = p.id
            JOIN
                sizes s ON pv.size_name = s.name
            JOIN 
                colors c ON pv.color_name = c.name
            WHERE
                p.id = :product_id AND
                c.name = :color_name',
            [
                'product_id' => $this->id,
                'color_name' => $this->color
            ]
        );
    }


    public static function getProductsVariantsByIds(array $ids): array
    {
        $ids = implode(',', array_keys($ids));

        $queryResult = Db::fetchAll(
            "SELECT 
                    pv.*,
                    pv.id AS variant_id,
                    pi.image_name,
                    p.*
                FROM 
                    products_variants pv
                JOIN
                    products p ON pv.product_id = p.id
                JOIN
                    products_images pi ON pv.product_id = pi.product_id AND pv.color_name = pi.color_name
                WHERE 
                    pv.id IN ($ids)"
        );

        $productArray = [];
        foreach ($queryResult as $row) {
            $productArray[] = self::createProductVariant($row);
        }

        return $productArray;
    }

    private static function createProductVariant(array $productRow): self
    {
        $product = new self();
        $product->id = $productRow['id'] ?? 0;
        $product->title = $productRow['title'] ?? '';
        $product->price = $productRow['price'] ?? 0;
        $product->description = $productRow['description'] ?? '';
        $product->imageName = $productRow['image_name'] ?? '';
        $product->color = $productRow['color_name'] ?? '';
        $product->size = $productRow['size_name'] ?? '';
        $product->quantity = $productRow['quantity'] ?? 0;
        $product->variantId = $productRow['variant_id'] ?? null;

        return $product;
    }

    private static function createProduct(array $productRow): self
    {
        $product = new self();
        $product->id = $productRow['id'] ?? 0;
        $product->title = $productRow['title'] ?? '';
        $product->price = $productRow['price'] ?? 0;
        $product->description = $productRow['description'] ?? '';
        $product->imageName = $productRow['image_name'] ?? '';

        return $product;
    }
}