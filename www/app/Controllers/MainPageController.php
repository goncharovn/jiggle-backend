<?php

namespace jiggle\app\Controllers;

use jiggle\app\Core\Controller;
use jiggle\app\Models\ProductModel;

class MainPageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function showMainPage(): void
    {
        $products = ProductModel::getProducts();

        $this->view->render(
            'main/index',
            'Get Your Jiggle On | Cycle, Run & Outdoor Shop | Jiggle',
            [
                'products' => $products,
            ]
        );
    }
}