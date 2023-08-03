<?php

return [
    '' => [
        'controller' => 'main',
        'action' => 'index'
    ],
    'p/(?<id>\d+)' => [
        'controller' => 'main',
        'action' => 'product',
    ],
    'add-to-basket/(?<id>\d+)' => [
        'controller' => 'basket',
        'action' => 'addToBasket',
    ],
    'remove-from-basket/(?<id>\d+)' => [
        'controller' => 'basket',
        'action' => 'removeFromBasket',
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