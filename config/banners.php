<?php

return [
    'image_type' => 'webp',
    'quality' => 85,

    'sizes' => [
        'banner' => [640, 1024, 1440],
        'galerie' => [640, 1024],
    ],

    'paths' => [
        'trainings' => [
            'original' => 'trainings/banners',
            'variants' => 'trainings/banners/variants',
        ],
        'camps' => [
            'original' => 'camps/banners',
            'variants' => 'camps/banners/variants',
        ],
        'announcements' => [
            'original' => 'announcements/banners',
            'variants' => 'announcements/banners/variants',
        ],
        'avatars' => [
            'original' => 'users/avatars',
            'variants' => 'users/avatars/variants',
        ],
        'galeries' => [
            'trainings' => 'trainings/galeries/variants',
            'camps' => 'camps/galeries/variants',
            'announcements' => 'announcements/galeries/variants',
        ],
    ],
];
