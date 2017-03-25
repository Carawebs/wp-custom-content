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
    /**
     * Refers to a single instance of this class
     * @var Object|NULL
     */
    private static $instance = NULL;

    /**
     * Path to config file for custom post types
     * @var string
     */
    private $cptConfigPath;

    /**
     * Path to config file for custom taxonomies
     * @var string
     */
    private $taxConfigPath;

    /**
     * Plugin instantiation by singleton method.
     * @return Object Object instantiated from this class
     */
    public static function getInstance()
    {
        if ( NULL == self::$instance ) {
            self::$instance = new self;
        }
         return self::$instance;
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
        if (file_exists( dirname(ABSPATH, 2) . '/config/custom-content')) {
            // Bedrock config directory
            $path = dirname(ABSPATH, 2) . '/config/custom-content/';
        } else {
            // Config directory in this package
            $path = dirname(__FILE__) . '/config/';
        }
        // Define the paths to the config files for CPTs and custom taxonomies:
        $this->cptConfigPath = $path . 'cpt.php';
        $this->taxConfigPath = $path . 'tax.php';
    }

    private function initCustomPostTypes()
    {
        if (!file_exists($this->cptConfigPath)) return;
        add_action( 'init', function() {
            $this->setupCPTs();
        });
    }

    private function initCustomTaxonomies()
    {
        if (!file_exists($this->taxConfigPath)) return;
        add_action( 'init', function() {
            $this->setupCustomTaxonomies();
        });
    }

    private function setupCPTs() {
        new CPT\Setup(
            new CPT\Config($this->cptConfigPath),
            new CPT\Register()
        );
    }

    private function setupCustomTaxonomies()
    {
        $TaxSetup = new Taxonomy\Setup(
            new Taxonomy\Config($this->taxConfigPath),
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

$plugin = CustomContent::getInstance();
$plugin->bootstrap();
