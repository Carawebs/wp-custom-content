<?php
namespace Carawebs\CustomContent\CPT;

/**
* Control setup of custom post types.
*/
class Setup
{

    /**
     * Set properies, run the setup
     * @param Config   $config A config object (ArrayAccess) that defines the CPTs
     * @param Register $loader The class object that registers the CPTs.
     */
    function __construct(Config $config, Register $loader)
    {
        $this->loader = $loader;
        $this->setCPTs($config);
        $this->init();
    }

    /**
     * Set the CPT data array
     * @param Config $config
     */
    protected function setCPTs($config)
    {
        $this->CPTs = $config->container;
    }

    /**
     * Loop through defined CPTs and set them up.
     * @return void
     */
    protected function init()
    {
        foreach( $this->CPTs as $CPT ) {
            add_action( 'init', function() use( $CPT ) {
                $this->loader->setName($CPT['slug'], $CPT['singular_name'], $CPT['plural_name']);
                $this->loader->set_labels();
                $this->loader->custom_messages();
                $this->loader->register( $CPT['args'] );
            });
        }
    }
}
