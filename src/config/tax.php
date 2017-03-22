<?php
if ( ! defined( 'ABSPATH' ) ) exit;
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
    ]
];
return $taxonomies;
