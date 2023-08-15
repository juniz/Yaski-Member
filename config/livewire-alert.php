<?php

/*
 * For more details about the configuration, see:
 * https://sweetalert2.github.io/#configuration
 */
return [
    'alert' => [
        'position' => 'top-end',
        'timer' => 3000,
        'toast' => true,
        'text' => null,
        'showCancelButton' => false,
        'showConfirmButton' => false
    ],
    'confirm' => [
        'icon' => 'warning',
        'position' => 'center',
        'toast' => false,
        'timer' => null,
        'showConfirmButton' => true,
        'showCancelButton' => true,
        'cancelButtonText' => 'Tidak',
        'confirmButtonText' => 'Ya',
        'confirmButtonColor' => '#3085d6',
        'cancelButtonColor' => '#d33',
    ],
    'loading' => [
        'position' => 'center',
        'timer' => null,
        'toast' => false,
        'showConfirmButton' => false,
        'showCancelButton' => false,
        'onOpen' => 'function(){$(".swal2-container").css("background", "transparent");}'
    ]
];
