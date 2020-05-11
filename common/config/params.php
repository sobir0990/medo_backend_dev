<?php
return [
    'adminEmail' => getenv('ADMIN_EMAIL'),
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'upload_dir_file' => "@static/uploads/",
    'upload_dir_file_src' => getenv('STATIC_URL') . 'uploads/',
    'no_photo' => '1',
    'paycom' => [
        'login' => getenv('PAYCOM_LOGIN'),
        'test_key' => getenv('PAYCOM_TEST_KEY'),
        'key' => getenv('PAYCOM_KEY'),
    ],
    'thumbs' => [
        'icon' => [
            'w' => 50,
            'h' => 50,
            'q' => 65,
            'slug' => 'icon'
        ],
        'small' => [
            'w' => 320,
            'h' => 320,
            'q' => 65,
            'slug' => 'small'
        ],
        'low' => [
            'w' => 640,
            'h' => 640,
            'q' => 65,
            'slug' => 'low'
        ],
        'normal' => [
            'w' => 1024,
            'h' => 1024,
            'q' => 65,
            'slug' => 'normal'
        ]
    ],
    'images_ext' => [
        'jpg',
        'jpeg',
        'png',
        'bmp',
        'gif'
    ],
    'use_file_name' => true,
    'use_queue' => false,
    'file_not_founded' => '14',

];
