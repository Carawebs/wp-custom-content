<?php
/*
Plugin Name:       Carawebs Custom Content Types
Plugin URI:        http://carawebs.com
Description:       Build custom post types and taxonomies from a configuration file.
Version:           0.1
Author:            David Egan
Author URI:        http://dev-notes.eu
License:           GPL-2.0+
License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain:       address
Domain Path:       /languages
*/
namespace Carawebs\CustomContent;

if ( ! defined( 'ABSPATH' ) ) exit;
/**
* @TODO: Constants not needed - only used in this Class.
* @TODO: Ensure only a single instance of this Class.
* @TODO: Look for config files int he Bedrock config directory, fallback to config in this package.
*/
class CustomContent
{
    public static function getInstance()
    {

    }

    function bootstrap()
    {
        $this->autoload();
        $this->setPaths();
        $this->onActivation();
        $this->onDeactivation();
        $this->initCustomPostTypes();
        $this->initCustomTaxonomies();
    }

    private function setPaths()
    {
        // Bedrock config directory
        //$path = dirname(ABSPATH, 2) . '/config/';

        // Config directory in this package
        $path = dirname(__FILE__) . '/config/';

        // Define the path to the config file for CPTs:
        define('CARAWEBS_CPT_CONFIG', $path . 'cpt.php');
        // Define the path for the config file for custom taxonomies:
        define('CARAWEBS_CUSTOM_TAX_CONFIG', $path . 'tax.php');
    }

    private function initCustomPostTypes()
    {
        if (!file_exists(CARAWEBS_CPT_CONFIG)) return;
        add_action( 'init', function() {
            $this->setupCPTs();
        });
    }

    private function initCustomTaxonomies()
    {
        if (!file_exists(CARAWEBS_CUSTOM_TAX_CONFIG)) return;
        add_action( 'init', function() {
            $this->setupCustomTaxonomies();
        });
    }

    private function setupCPTs() {
        new CPT\Setup(
            new CPT\Config(CARAWEBS_CPT_CONFIG),
            new CPT\Register()
        );
    }

    private function setupCustomTaxonomies()
    {
        $TaxSetup = new Taxonomy\Setup(
            new Taxonomy\Config(CARAWEBS_CUSTOM_TAX_CONFIG),
            new Taxonomy\Register()
        );
    }

    private function onActivation()
    {
        register_activation_hook( __FILE__, function() {
            $this->autoload();
            $this->setPaths();
            $this->setupCPTs();
            $this->setupCustomTaxonomies();
            flush_rewrite_rules();
        });
    }

    private function onDeactivation()
    {
        register_deactivation_hook( __FILE__, function(){
            flush_rewrite_rules();
        });
    }

    /**
    * Load Composer autoload if available, otherwise register a simple autoload callback.
    *
    * @return void
    */
    private function autoload()
    {
        static $done;
        // Go ahead if $done == NULL or the class doesn't exist
        if ( ! $done && ! class_exists( 'Carawebs\CustomContent\CPT\Setup', true ) ) {
            $done = true;
            file_exists( __DIR__.'/vendor/autoload.php' )
            ? require_once __DIR__.'/vendor/autoload.php'
            : spl_autoload_register( function ( $class ) {
                if (strpos($class, __NAMESPACE__) === 0) {
                    $name = str_replace('\\', '/', substr($class, strlen(__NAMESPACE__)));
                    require_once __DIR__."/src{$name}.php";
                }
            });
        }
    }
}

$plugin = new CustomContent();
$plugin->bootstrap();
//add_action('plugins_loaded', )
