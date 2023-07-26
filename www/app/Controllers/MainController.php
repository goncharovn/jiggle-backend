<?php

namespace app\Controllers;

use app\Controller;
use database\Db;

class MainController extends Controller
{
    public function index(): void
    {
        $db = new Db;
        $params = [
            'id' => 1,
        ];

        var_dump($db->column('SELECT name FROM users WHERE id = :id', $params));

        $this->view->render('Get Your Jiggle On | Cycle, Run & Outdoor Shop | Jiggle');
    }
}