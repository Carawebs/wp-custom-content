<?php
namespace Carawebs\CustomContent\Config;

/**
* Get the data from a specified config file
*/
class CPT implements \ArrayAccess {

    public $container = [];

    function __construct( $config ) {
        $this->container = include $config;
    }

    public function offsetExists ($offset) {

        return isset($this->container[$offset]);

    }

    public function offsetGet ($offset) {

        return isset($this->container[$offset]) ? $this->container[$offset] : null;

    }

    public function offsetSet ($offset, $value) {

        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }

    }

    public function offsetUnset ($offset) {

        unset($this->container[$offset]);

    }

}
