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

require( dirname( __FILE__ ) . '/autoloader.php' );

// Bedrock config directory
//$path = dirname(ABSPATH, 2) . '/config/';

// Config directory in this package
$path = dirname(__FILE__) . '/config/';

// Define the path to the config file for CPTs:
define('CARAWEBS_CPT_CONFIG', $path . 'cpt.php');
// Define the path for the config file for custom taxonomies:
define('CARAWEBS_CUSTOM_TAX_CONFIG', $path . 'tax.php');

function setupCPTs()
{
    if (!file_exists(CARAWEBS_CPT_CONFIG)) return;
    $CPTSetup = new CPT\Setup(
        new CPT\Config(CARAWEBS_CPT_CONFIG),
        new CPT\Register()
    );
}

function setupCustomTax()
{
    if (!file_exists(CARAWEBS_CUSTOM_TAX_CONFIG)) return;
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
