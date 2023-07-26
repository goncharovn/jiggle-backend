<?php

namespace app\Controllers;

use app\Controller;

class MainController extends Controller
{
    public function index(): void
    {
        $this->view->render('Get Your Jiggle On | Cycle, Run & Outdoor Shop | Jiggle');
    }
}