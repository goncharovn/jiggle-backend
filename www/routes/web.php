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
    'add-to-basket/(?<id>\d+)' => [
        'controller' => 'product',
        'action' => 'addProductIdToBasket',
    ],
    'remove-from-basket/(?<id>\d+)' => [
        'controller' => 'basket',
        'action' => 'removeProductIdFromBasket',
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
    'login' => [
        'controller' => 'login',
        'action' => 'login'
    ],
    'reset-password' => [
        'controller' => 'resetPassword',
        'action' => 'resetPassword'
    ],
    'change-password' => [
        'controller' => 'resetPassword',
        'action' => 'changePassword'
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