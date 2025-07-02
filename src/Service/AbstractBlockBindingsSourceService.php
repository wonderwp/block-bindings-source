<?php

namespace WonderWp\Component\BlockBindingsSource\Service;

use WonderWp\Component\BlockBindingsSource\Definition\BlockBindingsSourceInterface;
use WonderWp\Component\BlockBindingsSource\Exception\BlockBindingsSourceRegistrationException;
use WonderWp\Component\BlockBindingsSource\Response\BlockBindingsSourceRegistrationResponse;
use WonderWp\Component\BlockBindingsSource\Response\BlockBindingsSourceRegistrationResponseInterface;
use WonderWp\Component\CPT\Response\CustomPostTypeRegistrationResponseInterface;
use WonderWp\Component\Service\AbstractService;
use WP_Block_Bindings_Source;

abstract class AbstractBlockBindingsSourceService extends AbstractService implements BlockBindingsSourceServiceInterface
{
    /** @var BlockBindingsSourceInterface[] */
    protected array $blockBindingsSources = [];

    public function getBlockBindingsSources(): array
    {
        return $this->blockBindingsSources;
    }

    public function getBlockBindingsSource(string $key): ?BlockBindingsSourceInterface
    {
        return $this->blockBindingsSources[$key] ?? null;
    }

    public function addBlockBindingsSource(BlockBindingsSourceInterface $blockBindingsSource): static
    {
        $this->blockBindingsSources[$blockBindingsSource->getSourceName()] = $blockBindingsSource;

        return $this;
    }

    public function removeBlockBindingsSource(string $key): static
    {
        if (isset($this->blockBindingsSources[$key])) {
            unset($this->blockBindingsSources[$key]);
        }

        return $this;
    }

    public function setBlockBindingsSources(array $blockBindingsSources): static
    {
        $this->blockBindingsSources = $blockBindingsSources;

        return $this;
    }

    //========================================================================================================//
    // Registration methods
    //========================================================================================================//

    public function registerBlockBindingsSources(): array
    {
        $responses = [];

        foreach ($this->blockBindingsSources as $blockBindingsSource) {
            $responses[$blockBindingsSource->getSourceName()] = $this->registerBlockBindingsSource($blockBindingsSource);
        }

        return $responses;
    }

    public function registerBlockBindingsSource(BlockBindingsSourceInterface $blockBindingsSource): BlockBindingsSourceRegistrationResponseInterface
    {
        try {
            $wpRes = register_block_bindings_source(
                $blockBindingsSource->getSourceName(),
                $blockBindingsSource->getSourceProperties()
            );
            if (!$wpRes instanceof WP_Block_Bindings_Source) {
                throw new BlockBindingsSourceRegistrationException(BlockBindingsSourceRegistrationResponseInterface::ERROR);
            }
            $response = new BlockBindingsSourceRegistrationResponse(200, BlockBindingsSourceRegistrationResponseInterface::SUCCESS);
            $response->setWpRegistrationResult($wpRes);
        } catch (\Exception $e) {
            $errorCode = is_int($e->getCode()) ? $e->getCode() : 500;
            $response = new BlockBindingsSourceRegistrationResponse($errorCode, CustomPostTypeRegistrationResponseInterface::ERROR);
            $response->setError($e);
        }

        return $response;
    }
}
