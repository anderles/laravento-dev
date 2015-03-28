<?php
/** {license_text}  */
return [
    // Enable cache
    'cache_enabled' => ('production' == env('APP_ENV')),
    'filesystem' => [
        // Theme directory
        'design' => realpath(base_path('resources/design')),

        // Skin directory settings for Flysystem
        'public' => [
            'driver'     => 'local',
            'path'       => realpath(base_path('public/design'))
        ],
    ],
    'frontend' => [
        // Skin base url
        'base_url' => function () { return asset('design'); }
    ],
    'theme' => [
        // Default theme (used for fallback after current theme), if null will be used default dir
        'default' => null,
        // Current theme
        'current' => null,
    ],
    // Current design package, if null will be used base directory
    'package' => null,
];
