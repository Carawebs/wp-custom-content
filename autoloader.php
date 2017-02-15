<?php
/**
 * @author  David Egan <david@carawebs.com>
 * @license https://opensource.org/licenses/MIT
 *
 */
namespace Carawebs\CustomContent;

if ( ! defined( 'ABSPATH' ) ) exit;

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
