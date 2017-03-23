<?php
namespace Carawebs\CustomContent\CPT;

/**
* Control setup of custom post types.
*/
class Setup
{
    /**
     * Object used to register custom post types.
     * @var Object
     */
    private $loader;

    /**
     * Data used to construct custom post types (CPTs)
     * @var Array
     */
    private $CPTs;


    /**
     * Set properies, run the setup
     * @param Config   $config A config object (ArrayAccess) that defines the CPTs
     * @param Register $loader The class object that registers the CPTs.
     */
    function __construct(Config $config, Register $register)
    {
        $this->register = $register;
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
            $this->register->setVariables($CPT)->init();
            // add_action( 'init', function() use( $CPT ) {
            //     $this->register->setVariables($CPT)->init();
            // });
        }
    }
}
