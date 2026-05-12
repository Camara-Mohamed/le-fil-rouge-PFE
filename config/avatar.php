<?php

return [
    'image_type'       => 'jpg',
    'sizes'            => [
        'small'  => ['width' => '80',  'height' => '80'],
        'medium' => ['width' => '300', 'height' => '300'],
        'large'  => ['width' => '600', 'height' => '600'],
    ],
    'jpeg_compression' => 80,
    'original_path'    => 'avatars/originals',
    'variant_pattern'  => 'avatars/variants/%sx%s',
];
