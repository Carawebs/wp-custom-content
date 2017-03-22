# WP CPT
A library which registers WordPress custom post types and custom taxonomies. If you'd rather use this functionality as a WordPress plugin, use the master branch of this repo.

This is designed for use with [Bedrock](https://roots.io/bedrock/). Bedrock has an improved project structure compared to regular WordPress installations.

- [Bedrock on Packagist](https://packagist.org/packages/roots/bedrock).

The library is intended as an aid for developers - there is no settings GUI.  Instead, a configuration file which returns a PHP array is used to register custom post types and taxonomies. This means you can easily define custom post types and taxonomies for your project by simply amending an array.

## Config Files
Sample config files are provided in the `/sample-config` directory.

By default, the plugin looks for config files in the `src/config` directory.

To use, add this within your theme:
~~~php
CptLoader::create()->setConfigPath()->setup();
TaxonomyLoader::create()->setConfigPath()->setup();
~~~

Override the location of config files by passing a argument (string) to `setConfigPath()`

## To Do
- Config files should be in YAML format to make them easier to edit.
- Proper error handling if there is no config file.
