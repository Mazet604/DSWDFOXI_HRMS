<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'emp_acc',
    ],

    // config/auth.php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\EmpAcc::class,
    ],
],


    'passwords' => [
        'emp_acc' => [
            'provider' => 'emp_acc',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
