<?php

use app\Controllers\MainPageController;
use app\Controllers\ProductController;
use app\Controllers\AccountPagesController;
use app\Controllers\SignupController;
use app\Controllers\ProfileController;
use app\Controllers\LoginController;
use app\Controllers\ResetPasswordController;
use app\Controllers\BasketController;

return [
    '#^$#' => [
        'controller' => MainPageController::class,
        'action' => 'index'
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
        'action' => 'index'
    ],
    '#^my-account/order-history$#' => [
        'controller' => AccountPagesController::class,
        'action' => 'orderHistory'
    ],
    '#^my-account/delivery-address$#' => [
        'controller' => AccountPagesController::class,
        'action' => 'deliveryAddress'
    ],
    '#^my-account/my-details$#' => [
        'controller' => AccountPagesController::class,
        'action' => 'myDetails'
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
        'action' => 'login'
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
];