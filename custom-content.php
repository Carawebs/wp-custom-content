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

if ( ! defined( 'WPINC' ) ) {
    die;
}
require_once(ABSPATH . 'wp-admin/includes/file.php');
$path = dirname(get_home_path()) . '/config/';
define('CARAWEBS_CUSTOM_CONTENT_CONFIG', $path . 'cpt-config.php');
define('CARAWEBS_CUSTOM_TAX_CONFIG', $path . 'tax-config.php');

function setupCPTs()
{
    $CPTSetup = new CPT\Setup(
        new CPT\Config(CARAWEBS_CUSTOM_CONTENT_CONFIG),
        new CPT\Register()
    );
}

function setupCustomTax()
{
    $TaxSetup = new Taxonomy\Setup(
        new Taxonomy\Config(CARAWEBS_CUSTOM_TAX_CONFIG),
        new Taxonomy\Register()
    );

}

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

/**
* Load Composer autoload if available, otherwise register a simple autoload callback.
*
* @return void
*/
function autoload() {

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
