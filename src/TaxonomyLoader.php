<?php

namespace Carawebs\CustomContent;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 *
 */
class TaxonomyLoader extends Loader
{
    public function setConfigPathDefault()
    {
        $this->configPathDefault = dirname(__FILE__) . '/config/tax.php';
    }

    public function setup()
    {
        if (!file_exists($this->configPath)) return;
        $TaxSetup = new Taxonomy\Setup(
            new Taxonomy\Config($this->configPath),
            new Taxonomy\Register()
        );
    }
}
