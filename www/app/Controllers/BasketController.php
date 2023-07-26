<?php

namespace app\Controllers;

use app\Controller;

class BasketController extends Controller
{
    public function index(): void
    {
        $this->view->render('Jiggle - Basket');
    }
}