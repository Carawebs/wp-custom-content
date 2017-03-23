<?php
namespace Carawebs\CustomContent\Taxonomy;

/**
* Class registers service category custom taxonomy
*/
class Register extends CustomTaxonomy
{

    public function setVariables(array $taxConfig)
    {
        $this->tax_slug = $taxConfig['slug'];
        $this->singular_name = $taxConfig['singular_name'];
        $this->plural_name = $taxConfig['plural_name'];
        $this->cpts = $taxConfig['related_CPTs'];
        $this->overrideArgs = $taxConfig['override_args'] ?? [];
        return $this;
    }

    public function init()
    {
        $this->setLabels();
        $this->register();
    }
}
