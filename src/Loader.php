<?php

namespace Carawebs\CustomContent;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 *
 */
abstract class Loader
{
    public $configPath;

    function __construct()
    {
        $this->setConfigPathDefault();
    }

    public static function create()
    {
        return new static;
    }

    public function setConfigPath($configPath = NULL)
    {
        $this->configPath = $configPath ?? $this->configPathDefault;
        return $this;
    }
}
