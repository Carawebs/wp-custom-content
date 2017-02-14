<?php
namespace Carawebs\CustomContent\CPT;

/**
*
*/
class Setup {

    function __construct($config, Register $loader) {
        $this->loader = $loader;
        $this->setCPTs($config);
        $this->init();
    }

    protected function setCPTs($config)
    {
        $this->CPTs = $config;
        error_log("Set");
    }

    protected function init() {

        error_log("FUNC init");
        foreach( $this->CPTs->container as $CPT ) {

            //var_dump($CPT);

            add_action( 'init', function() use( $CPT ) {// NEEDS TO BE init
            //var_dump($CPT);
            error_log('INIT');

                $this->loader->setName($CPT['slug'], $CPT['singular_name'], $CPT['plural_name']);
                $this->loader->set_labels();
                $this->loader->custom_messages();
                $this->loader->register( $CPT['args'] );

            });

        }

    }
}
