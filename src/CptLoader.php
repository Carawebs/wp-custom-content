<?php

namespace Carawebs\CustomContent;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 *
 */
class CptLoader extends Loader
{
    public function setConfigPathDefault()
    {
        $this->configPathDefault = dirname(__FILE__) . '/config/cpt.php';
    }

    public function setup()
    {
        if (!file_exists($this->configPath)) return;
        $CPTSetup = new CPT\Setup(
            new CPT\Config($this->configPath),
            new CPT\Register()
        );
    }
}
