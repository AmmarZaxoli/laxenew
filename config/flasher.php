<?php

return [
    'default' => 'sweetalert', // Make SweetAlert the default

    'plugins' => [
        'sweetalert' => [
            'scripts' => [
                '/vendor/flasher/sweetalert2.min.js',
                '/vendor/flasher/flasher-sweetalert.min.js',
            ],
            'styles' => [
                '/vendor/flasher/sweetalert2.min.css',
            ],
            'options' => [
                'toast' => true,
                'position' => 'top-start',
                'showConfirmButton' => false,
                'timer' => 4000,
            ],
        ],
    ],
];
