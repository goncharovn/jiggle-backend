<?php

namespace jiggle\app\Views;

use jiggle\app\Core\View;
use jiggle\app\Models\ProductModel;

class ProductsView
{
    public static function make(): bool|string
    {
        $products = ProductModel::getProducts();

        return View::make(
            'products',
            [
                'products' => $products
            ]
        );
    }
}