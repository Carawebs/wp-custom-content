<?php
namespace Carawebs\WPCustomContent\Taxonomy;

/**
* Class registers service category custom taxonomy
*/
class Register extends CustomTaxonomy {

    function __construct() {

        $this->tax_slug = 'project-category';
        $this->singular_name = 'project category';
        $this->plural_name = 'project categories';
        $this->cpts = ['project'];
        $this->set_labels();

    }

    public function init() {

        $args =[
            'hierarchical' => false,
        ];

        $this->register( $args );

    }

}
