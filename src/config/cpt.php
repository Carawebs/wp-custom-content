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
        'slug'          => 'person',
        'singular_name' => 'person',
        'plural_name'   => 'people',
        'args'          => ['menu_icon' => 'dashicons-groups']
    ]
];

return $cpts;
