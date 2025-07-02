<?php

namespace WonderWp\Component\BlockBindingsSource\Traits;

trait HasBlockBindingsSourceDefinitions
{
    public function __construct()
    {
        $this->setSourceName(static::provideSourceName());
        $this->setSourceProperties($this->provideSourceProperties());
    }
}
