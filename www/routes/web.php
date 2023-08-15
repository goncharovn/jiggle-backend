<?php

return [
    '' => [
        'controller' => 'mainPage',
        'action' => 'index'
    ],
    'p/(?<id>\d+)' => [
        'controller' => 'product',
        'action' => 'index',
    ],
    'remove-product' => [
        'controller' => 'product',
        'action' => 'removeProductFromBasket',
    ],
    'my-account' => [
        'controller' => 'accountPages',
        'action' => 'index'
    ],
    'my-account/order-history' => [
        'controller' => 'accountPages',
        'action' => 'orderHistory'
    ],
    'my-account/delivery-address' => [
        'controller' => 'accountPages',
        'action' => 'deliveryAddress'
    ],
    'my-account/my-details' => [
        'controller' => 'accountPages',
        'action' => 'myDetails'
    ],
    'signup' => [
        'controller' => 'signup',
        'action' => 'signup'
    ],
    'confirm-signup' => [
        'controller' => 'signup',
        'action' => 'confirmSignup'
    ],
    'confirm-email' => [
        'controller' => 'profile',
        'action' => 'confirmEmail'
    ],
    'login' => [
        'controller' => 'login',
        'action' => 'login'
    ],
    'login/disable-2fa' => [
        'controller' => 'login',
        'action' => 'disableMultiFactorAuth'
    ],
    'login/enable-2fa' => [
        'controller' => 'login',
        'action' => 'enableMultiFactorAuth'
    ],
    'login/process-2fa' => [
        'controller' => 'login',
        'action' => 'processMultiFactorAuth'
    ],
    'reset-password' => [
        'controller' => 'resetPassword',
        'action' => 'resetPassword'
    ],
    'change-password' => [
        'controller' => 'resetPassword',
        'action' => 'changePassword'
    ],
    'change-name' => [
        'controller' => 'profile',
        'action' => 'changeName'
    ],
    'change-email' => [
        'controller' => 'profile',
        'action' => 'changeEmail'
    ],
    'signout' => [
        'controller' => 'profile',
        'action' => 'signout'
    ],
    'basket' => [
        'controller' => 'basket',
        'action' => 'index'
    ],
];