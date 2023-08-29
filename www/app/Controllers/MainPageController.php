<?php

namespace jiggle\app\Controllers;

use jiggle\app\Core\Controller;
use jiggle\app\Views\Layouts\DefaultLayout;
use jiggle\app\Views\ProductsView;

class MainPageController extends Controller
{
    public function showMainPage(): void
    {
        DefaultLayout::render(
            'Get Your Jiggle On | Cycle, Run & Outdoor Shop | Wiggle',
            ProductsView::make()
        );
    }
}