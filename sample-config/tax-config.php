<?php
if ( ! defined( 'WPINC' ) ) {
    die;
}
$taxonomies = [
    [
        'slug'          => 'project-category',
        'singular_name' => 'project category',
        'plural_name'   => 'project categories',
        'related_CPTs'  => [
            'project'
        ],
        'override_args' => [
            'hierarchical' => false
        ]
    ],
    [
        'slug'          => 'service-category',
        'singular_name' => 'service category',
        'plural_name'   => 'service categories',
        'related_CPTs'  => [
            'service'
        ],
    ],
];
return $taxonomies;
