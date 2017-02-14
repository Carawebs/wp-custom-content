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

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
require_once(ABSPATH . 'wp-admin/includes/file.php');
$path = dirname(get_home_path());
define('CARAWEBS_CUSTOM_CONTENT_CONFIG', '/var/www/html/cpt.dev/config/cpt-config.php');
$CPTcontroller = new CPT\Setup(
    new Config\CPT(CARAWEBS_CUSTOM_CONTENT_CONFIG),
    new CPT\Register()
);
add_action( 'init', function () {

    autoload();
    //settings();

    // $CPTcontroller = new CPT\Setup(
    //     new Config\CPT(CARAWEBS_CUSTOM_CONTENT_CONFIG),
    //     new CPT\Register()
    // );

    // Setup backend actions
    //$controller->setupBackendActions();

    // Setup frontend action
    //$controller->setupFrontendActions();

});

// require_once( __DIR__."/src/Activator.php" ); // NB: no autoloader at this point!
// register_activation_hook( __FILE__, [ new Activator(), 'activate' ] );
//
// require_once( __DIR__."/src/Deactivator.php" );
// register_deactivation_hook( __FILE__, [ new Deactivator(), 'deactivate' ] );

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

function settings() {

    // Menu Page
    $settings = new Settings\MenuPage(
        //new Settings\Config('organise-posts', new \Symfony\Component\Yaml\Parser(), 'src/Settings/data2.yml' )
        new Settings\Config('organise-posts' )
    );

}
