<?php

namespace app\Controllers;

use app\Controller;
use app\Model;
use app\Models\ProductsModel;

class MainPageController extends Controller
{
    public Model $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new ProductsModel();
    }

    public function index(): void
    {
        $products = $this->model->getProducts();

        $this->view->render(
            'main/index',
            'Get Your Jiggle On | Cycle, Run & Outdoor Shop | Jiggle',
            [
                'products' => $products,
            ]
        );
    }
}