<?php

namespace WonderWp\Component\BlockBindingsSource\Definition;

abstract class AbstractBlockBindingsSource implements BlockBindingsSourceInterface
{
    protected string $sourceName = '';
    protected array $sourceProperties = [];

    public function getSourceName(): string
    {
        return $this->sourceName;
    }

    public function setSourceName(string $sourceName): static
    {
        $this->sourceName = $sourceName;
        return $this;
    }

    public function getSourceProperties(): array
    {
        return $this->sourceProperties;
    }

    public function setSourceProperties(array $sourceProperties): static
    {
        $this->sourceProperties = $sourceProperties;
        return $this;
    }
} 