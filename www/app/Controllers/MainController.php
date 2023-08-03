<?php

namespace app\Controllers;

use app\Controller;

class MainController extends Controller
{
    public function index(): void
    {
        $products = $this->model->getProducts();

        $vars = [
            'products' => $products,
        ];

        $this->view->render('main/index','Get Your Jiggle On | Cycle, Run & Outdoor Shop | Jiggle', $vars);
    }

    public function product()
    {
        $id = $this->route['id'];

        $product = $this->model->getProduct($id);

        $vars = [
            'product' => $product,
        ];

        $this->view->render('main/product', 'Product', $vars);
    }
}