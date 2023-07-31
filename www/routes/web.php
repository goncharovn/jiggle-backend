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
    'login' => [
        'controller' => 'account',
        'action' => 'login'
    ],
    'signup' => [
        'controller' => 'account',
        'action' => 'signup'
    ],
    'reset-password' => [
        'controller' => 'account',
        'action' => 'resetPassword'
    ],
    'basket' => [
        'controller' => 'basket',
        'action' => 'index'
    ],
];