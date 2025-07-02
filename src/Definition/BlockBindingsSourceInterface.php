<?php

namespace WonderWp\Component\BlockBindingsSource\Definition;

interface BlockBindingsSourceInterface
{
    public function getSourceName(): string;
    public function setSourceName(string $sourceName): static;
    public function getSourceProperties(): array;
    public function setSourceProperties(array $sourceProperties): static;
} 