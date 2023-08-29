<?php

namespace jiggle\app\Views;

use jiggle\app\Core\View;

class AdminEditProductVariantView
{
    public static function make(): string
    {
        return View::make(
            'admin_edit_product_variant',
            [

            ]
        );
    }
}