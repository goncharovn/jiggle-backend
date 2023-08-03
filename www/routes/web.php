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
    'account' => [
        'controller' => 'account',
        'action' => 'index'
    ],
    'signup' => [
        'controller' => 'account',
        'action' => 'signup'
    ],
    'login' => [
        'controller' => 'account',
        'action' => 'login'
    ],
    'reset-password' => [
        'controller' => 'account',
        'action' => 'resetPassword'
    ],
    'handle-signup' => [
        'controller' => 'account',
        'action' => 'handleSignup'
    ],
    'handle-login' => [
        'controller' => 'account',
        'action' => 'handleLogin'
    ],
    'basket' => [
        'controller' => 'basket',
        'action' => 'index'
    ],
];