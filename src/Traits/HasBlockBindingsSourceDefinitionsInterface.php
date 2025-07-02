<?php

namespace WonderWp\Component\BlockBindingsSource\Traits;

interface HasBlockBindingsSourceDefinitionsInterface
{
    /**
     * Provide the block bindings source name
     * @return string
     */
    public static function provideSourceName(): string;

    /**
     * Provide the block bindings source properties
     * @return array
     */
    public function provideSourceProperties(): array;
}
