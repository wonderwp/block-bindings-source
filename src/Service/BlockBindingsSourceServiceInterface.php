<?php

namespace WonderWp\Component\BlockBindingsSource\Service;

use WonderWp\Component\BlockBindingsSource\Definition\BlockBindingsSourceInterface;

interface BlockBindingsSourceServiceInterface
{
    public function addBlockBindingsSource(BlockBindingsSourceInterface $blockBindingsSource): static;
    public function getBlockBindingsSource(string $key): ?BlockBindingsSourceInterface;
    public function getBlockBindingsSources(): array;
    public function registerBlockBindingsSources(): array;
    public function setBlockBindingsSources(array $blockBindingsSources): static;
}
