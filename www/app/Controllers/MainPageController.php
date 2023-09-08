<?php

namespace jiggle\app\Controllers;

use jiggle\app\Core\Controller;
use jiggle\app\Models\ProductModel;
use jiggle\app\Views\Components\DefaultLayoutComponent;
use jiggle\app\Views\Components\ProductsComponent;

class MainPageController extends Controller
{
    public function showMainPage(): void
    {
        $products = ProductModel::getProducts();

        echo new DefaultLayoutComponent(
            'Get Your Jiggle On | Cycle, Run & Outdoor Shop | Wiggle',
            new ProductsComponent($products)
        );
    }
}