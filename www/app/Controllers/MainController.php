<?php

namespace app\Controllers;

use app\Controller;
use database\Db;

class MainController extends Controller
{
    public function index(): void
    {
        $products = $this->model->getProducts();
        $vars = [
            'products' => $products,
        ];
        $this->view->render('Get Your Jiggle On | Cycle, Run & Outdoor Shop | Jiggle', $vars);
    }

    public function product()
    {
        $id = $this->route['id'];
        $product = $this->model->getProduct($id);
        $vars = [
            'product' => $product,
        ];
        $this->view->render('Product', $vars);
    }
}