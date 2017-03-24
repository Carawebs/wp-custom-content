<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$cpts = [
    [
        'slug'          => 'project',
        'singular_name' => 'project',
        'plural_name'   => 'projects',
        'args'          => [
            'menu_icon'   => 'dashicons-analytics',
            'has_archive' => true,
            'taxonomies'  => [ 'post_tag' ],
        ]
    ],
    [
        'slug'          => 'landing-page',
        'singular_name' => 'Landing Page',
        'plural_name'   => 'Landing Pages',
        'args'          => ['menu_icon' => 'dashicons-cart']

    ],
    [
        'slug'          => 'service',
        'singular_name' => 'service',
        'plural_name'   => 'services',
        'args'          => ['menu_icon' => 'dashicons-hammer']

    ],
    [
        'slug'          => 'person',
        'singular_name' => 'person',
        'plural_name'   => 'people',
        'args'          => ['menu_icon' => 'dashicons-groups']

    ]
];

return $cpts;
