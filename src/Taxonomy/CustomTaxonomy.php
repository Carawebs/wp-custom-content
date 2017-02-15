<?php
namespace Carawebs\CustomContent\Taxonomy;

/**
* Base class that registers Custom taxonomies
*/
abstract class CustomTaxonomy
{

    public function setLabels()
    {

        $this->labels = [
            'name'                       => __( ucwords($this->plural_name), 'carawebs-cpt' ),
            'singular_name'              => _x( $this->singular_name, 'taxonomy general name', 'carawebs-cpt' ),
            'search_items'               => __( 'Search ' . $this->plural_name, 'carawebs-cpt' ),
            'popular_items'              => __( 'Popular ' . $this->plural_name, 'carawebs-cpt' ),
            'all_items'                  => __( 'All ' . $this->plural_name, 'carawebs-cpt' ),
            'parent_item'                => __( 'Parent ' . $this->singular_name, 'carawebs-cpt' ),
            'parent_item_colon'          => __( 'Parent ' . $this->singular_name . ':', 'carawebs-cpt' ),
            'edit_item'                  => __( 'Edit ' . $this->singular_name, 'carawebs-cpt' ),
            'view_item'                  => __( 'View ' . $this->singular_name . ' page' ),
            'update_item'                => __( 'Update ' . $this->singular_name, 'carawebs-cpt' ),
            'add_new_item'               => __( 'New ' . $this->singular_name, 'carawebs-cpt' ),
            'new_item_name'              => __( 'New ' . $this->singular_name, 'carawebs-cpt' ),
            'separate_items_with_commas' => __( $this->plural_name . ' separated by comma', 'carawebs-cpt' ),
            'add_or_remove_items'        => __( 'Add or remove ' . $this->plural_name, 'carawebs-cpt' ),
            'choose_from_most_used'      => __( 'Choose from the most used ' . $this->plural_name, 'carawebs-cpt' ),
            'menu_name'                  => __( ucwords($this->plural_name), 'carawebs-cpt' ),
        ];

    }

    public function register()
    {

        $args = [

            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => false,
            'query_var'         => true,
            'rewrite'           => true,
            'capabilities'      => [
                'manage_terms'  => 'edit_posts',
                'edit_terms'    => 'edit_posts',
                'delete_terms'  => 'edit_posts',
                'assign_terms'  => 'edit_posts'
            ],
            'labels'            => $this->labels
        ];

        $args = array_merge( $args, $this->overrideArgs );
        register_taxonomy( $this->tax_slug, $this->cpts, $args );

    }

}
