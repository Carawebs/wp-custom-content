<?php

namespace Carawebs\CustomContent;

/**
 *
 */
class Loader
{
    protected $cptConfigPath;
    protected $taxConfigPath;

    function __construct()
    {
        if ( ! defined( 'ABSPATH' ) ) exit;
        $this->setCptConfig();
        $this->setTaxConfig();
        $this->setupCPTs();
    }

    public function setCptConfig()
    {
        $this->cptConfig = dirname(__FILE__) . '/config/cpt.php';
    }

    public function setTaxConfig()
    {
        $this->taxConfig = dirname(__FILE__) . '/config/tax.php';
    }

    public function setupCPTs()
    {
        if (!file_exists($this->cptConfig)) return;
        $CPTSetup = new CPT\Setup(
            new CPT\Config($this->cptConfig),
            new CPT\Register()
        );
    }

    public function setupCustomTax()
    {
        if (!file_exists($this->taxConfig)) return;
        $TaxSetup = new Taxonomy\Setup(
            new Taxonomy\Config($this->taxConfig),
            new Taxonomy\Register()
        );

    }
}


// // Define the path to the config file for CPTs:
// define('CARAWEBS_CUSTOM_CONTENT_CONFIG', $path . 'cpt-config.php');
// // Define the path for the config file for custom taxonomies:
// define('CARAWEBS_CUSTOM_TAX_CONFIG', $path . 'tax-config.php');

// function setupCPTs()
// {
//     $CPTSetup = new CPT\Setup(
//         new CPT\Config(CARAWEBS_CUSTOM_CONTENT_CONFIG),
//         new CPT\Register()
//     );
// }
//
// function setupCustomTax()
// {
//     $TaxSetup = new Taxonomy\Setup(
//         new Taxonomy\Config(CARAWEBS_CUSTOM_TAX_CONFIG),
//         new Taxonomy\Register()
//     );
//
// }

add_action( 'plugins_loaded', function() {
    autoload();
    setupCPTs();
    setupCustomTax();
});

register_activation_hook( __FILE__, function() {
    setupCPTs();
    flush_rewrite_rules();
});

register_deactivation_hook( __FILE__, function(){
    flush_rewrite_rules();
});
