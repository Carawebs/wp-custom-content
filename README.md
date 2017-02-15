# WP CPT
A WordPress plugin which registers:

- Custom post types
- Custom taxonomies

This plugin is designed for use with [Bedrock](https://roots.io/bedrock/). Bedrock has an improved project structure compared to regular WordPress installations. [Bedrock on Packagist](https://packagist.org/packages/roots/bedrock).

The plugin is intended as an aid for developers - there is no settings GUI.

Instead, a configuration file which returns a PHP array is used to register custom post types and taxonomies. This means you can easily define custom post types and taxonomies for your project by simply amending an array.

## Config Files
Sample config files are provided in the `/sample-config` directory.

By default, the plugin looks for config files in the Bedrock `config` directory - which is outside the document root for the project. If you're using a regular WordPress installation, you may need to fork this plugin and modify the path to the config files:

~~~php
<?php
// See: `/custom-content.php`
// Config file definitions:
require_once(ABSPATH . 'wp-admin/includes/file.php');
$path = dirname(get_home_path()) . '/config/';

// Define path to CPT config file.
define('CARAWEBS_CUSTOM_CONTENT_CONFIG', $path . 'cpt-config.php');

// Define path to custom taxonomy config file.
define('CARAWEBS_CUSTOM_TAX_CONFIG', $path . 'tax-config.php');
~~~

The default locations are:

- CPT config: `/path/to/example.com/config/cpt-config.php`
- Custom taxonomy config: `/path/to/example.com/config/tax-config.php`

If you're working in Bedrock and want to quickly copy across the sample config files, run this from the plugin root directory:

~~~bash
# At terminal/BASH prompt
cp sample-config/cpt-config.php ../../../../config/cpt-config.php

# More conservatively:
cp sample-config/cpt-config.php path/to/yoursite.com/config/cpt-config.php

~~~
## To Do
- Config files should be in YAML format to make them easier to edit.
- Proper error handling if there is no config file.
