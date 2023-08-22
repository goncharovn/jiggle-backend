<?php

use jiggle\app\Controllers\MainPageController;
use jiggle\app\Controllers\ProductController;
use jiggle\app\Controllers\AccountPagesController;
use jiggle\app\Controllers\SignupController;
use jiggle\app\Controllers\ProfileController;
use jiggle\app\Controllers\LoginController;
use jiggle\app\Controllers\ResetPasswordController;
use jiggle\app\Controllers\BasketController;
use jiggle\app\Controllers\AdminController;

return [
    '#^$#' => [
        'controller' => MainPageController::class,
        'action' => 'showMainPage'
    ],
    '#^p/(?<id>\d+)$#' => [
        'controller' => ProductController::class,
        'action' => 'index',
    ],
    '#^remove-product$#' => [
        'controller' => ProductController::class,
        'action' => 'removeProductFromBasket',
    ],
    '#^my-account$#' => [
        'controller' => AccountPagesController::class,
        'action' => 'showOverviewPage'
    ],
    '#^my-account/order-history$#' => [
        'controller' => AccountPagesController::class,
        'action' => 'showOrderHistoryPage'
    ],
    '#^my-account/delivery-address$#' => [
        'controller' => AccountPagesController::class,
        'action' => 'showDeliveryAddressPage'
    ],
    '#^my-account/my-details$#' => [
        'controller' => AccountPagesController::class,
        'action' => 'showMyDetailsPage'
    ],
    '#^signup$#' => [
        'controller' => SignupController::class,
        'action' => 'signup'
    ],
    '#^confirm-signup$#' => [
        'controller' => SignupController::class,
        'action' => 'confirmSignup'
    ],
    '#^login$#' => [
        'controller' => LoginController::class,
        'action' => 'processLogin'
    ],
    '#^login/disable-2fa$#' => [
        'controller' => LoginController::class,
        'action' => 'disableMultiFactorAuth'
    ],
    '#^login/enable-2fa$#' => [
        'controller' => LoginController::class,
        'action' => 'enableMultiFactorAuth'
    ],
    '#^login/process-2fa$#' => [
        'controller' => LoginController::class,
        'action' => 'processMultiFactorAuth'
    ],
    '#^reset-password$#' => [
        'controller' => ResetPasswordController::class,
        'action' => 'resetPassword'
    ],
    '#^change-password$#' => [
        'controller' => ResetPasswordController::class,
        'action' => 'changePassword'
    ],
    '#^confirm-email$#' => [
        'controller' => ProfileController::class,
        'action' => 'confirmEmail'
    ],
    '#^change-name$#' => [
        'controller' => ProfileController::class,
        'action' => 'changeName'
    ],
    '#^change-email$#' => [
        'controller' => ProfileController::class,
        'action' => 'changeEmail'
    ],
    '#^signout$#' => [
        'controller' => ProfileController::class,
        'action' => 'signout'
    ],
    '#^basket$#' => [
        'controller' => BasketController::class,
        'action' => 'index'
    ],
    '#^admin/products$#' => [
        'controller' => AdminController::class,
        'action' => 'showProductsPage'
    ],
    '#^admin/add-product$#' => [
        'controller' => AdminController::class,
        'action' => 'showAddProductPage'
    ],
    '#^admin/orders$#' => [
        'controller' => AdminController::class,
        'action' => 'showOrdersPage'
    ],
    '#^admin/customers$#' => [
        'controller' => AdminController::class,
        'action' => 'showCustomersPage'
    ],
];