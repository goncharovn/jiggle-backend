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
    '#^product/(?<id>\d+)$#' => [
        'controller' => ProductController::class,
        'action' => 'showProductPage',
    ],
    '#^remove-product-variant-from-basket$#' => [
        'controller' => BasketController::class,
        'action' => 'removeProductVariantFromBasket',
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
        'action' => 'showSignupPage'
    ],
    '#^process-signup$#' => [
        'controller' => SignupController::class,
        'action' => 'processSignup'
    ],
    '#^confirm-signup$#' => [
        'controller' => SignupController::class,
        'action' => 'confirmSignup'
    ],
    '#^login$#' => [
        'controller' => LoginController::class,
        'action' => 'showLoginPage'
    ],
    '#^process-login$#' => [
        'controller' => LoginController::class,
        'action' => 'processLogin'
    ],
    '#^login/process-multi-factor-auth$#' => [
        'controller' => LoginController::class,
        'action' => 'processMultiFactorAuth'
    ],
    '#^login/toggle-multi-factor-auth$#' => [
        'controller' => LoginController::class,
        'action' => 'toggleMultiFactorAuth'
    ],
    '#^reset-password$#' => [
        'controller' => ResetPasswordController::class,
        'action' => 'showResetPasswordPage'
    ],
    '#^process-reset-password$#' => [
        'controller' => ResetPasswordController::class,
        'action' => 'processResetPassword'
    ],
    '#^change-password$#' => [
        'controller' => ResetPasswordController::class,
        'action' => 'showChangePasswordPage'
    ],
    '#^process-change-password$#' => [
        'controller' => ResetPasswordController::class,
        'action' => 'processChangePassword'
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
    '#^sign-out$#' => [
        'controller' => ProfileController::class,
        'action' => 'signout'
    ],
    '#^basket$#' => [
        'controller' => BasketController::class,
        'action' => 'showBasketPage'
    ],
    '#^change-product-variant-quantity-in-basket$#' => [
        'controller' => BasketController::class,
        'action' => 'changeProductVariantQuantityInBasket'
    ],
    '#^admin/products$#' => [
        'controller' => AdminController::class,
        'action' => 'showProductsPage'
    ],
    '#^admin/add-product$#' => [
        'controller' => AdminController::class,
        'action' => 'showAddProductPage'
    ],
    '#^admin/edit-product$#' => [
        'controller' => AdminController::class,
        'action' => 'showEditProductPage'
    ],
    '#^admin/edit-product-variant$#' => [
        'controller' => AdminController::class,
        'action' => 'showEditProductVariantPage'
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