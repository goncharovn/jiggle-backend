<?php

namespace app\Controllers;

use app\Controller;
use database\Db;

class MainController extends Controller
{
    public function index(): void
    {
        $result = $this->model->getProducts();
        $vars = [
            'products' => $result,
        ];
        $this->view->render('Get Your Jiggle On | Cycle, Run & Outdoor Shop | Jiggle', $vars);
    }
}