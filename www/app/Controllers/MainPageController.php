<?php

namespace app\Controllers;

use app\Controller;
use app\Models\ProductModel;

class MainPageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(): void
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