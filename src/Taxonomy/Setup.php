<?php
namespace Carawebs\CustomContent\Taxonomy;

/**
* Control Custom Taxonomy setup.
*/
class Setup {
    /**
     * Set properties and run the setup.
     *
     * @param Config   $config A config object (ArrayAccess).
     * @param Register $loader The class object that registers custom taxonomies.
     */
    function __construct(Config $config, Register $loader) {
        $this->loader = $loader;
        $this->setTaxConfig($config);
        $this->init();
    }

    /**
     * Set the configuration object
     * @param Config $config ArrayAccess object.
     */
    protected function setTaxConfig($config)
    {
        $this->taxConfig = $config->container;
    }

    /**
     * Loop through and register taxonomies.
     *
     * @return void
     */
    protected function init()
    {
        foreach( $this->taxConfig as $tax ) {
            add_action( 'init', function() use( $tax ) {
                $this->loader->setVariables($tax)->init();
            });
        }
    }
}
