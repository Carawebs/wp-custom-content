<?php
namespace Carawebs\CustomContent\CPT;

/**
*
*/
class Setup {

    function __construct(Register $loader) {
        $this->set_CPTs();
        $this->init();
    }

    protected function init() {

        foreach( $this->CPTs as $CPT ) {

            add_action( 'init', function() use( $CPT ) {

                $loader = new Register(
                    $cpt['slug'],
                    $cpt['singular_name'],
                    $cpt['plural_name']
                );

                $loader->register( $CPT['args'] );

            });

        }

    }
}
