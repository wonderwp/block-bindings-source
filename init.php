<?php

use WonderWp\Component\BlockBindingsSource\Service\BlockBindingsSourceService;
use WonderWp\Component\BlockBindingsSource\Service\BlockBindingsSourceServiceInterface;
use WonderWp\Component\PluginSkeleton\Exception\ServiceNotFoundException;
use WonderWp\Component\PluginSkeleton\ManagerAwareInterface;
use WonderWp\Component\Service\ServiceInterface;
use WonderWp\Component\PluginSkeleton\ManagerInterface;
use WonderWp\Component\DependencyInjection\Container;

add_action('wonderwp.loader.load', 'wwp_register_blockbindingssources_definitions_towards_container', 10, 2);
add_action('wwp.abstract_manager.run', 'wwp_register_blockbindingssources_service_towards_manager', 10, 2);

function wwp_register_blockbindingssources_definitions_towards_container(Container $container)
{
    /**
     * Block Bindings Sources
     */
    $container['wwp.blockBindingsSource.defaultService'] = $container->factory(function () {
        return new BlockBindingsSourceService();
    });
}

function wwp_register_blockbindingssources_service_towards_manager(ManagerInterface $manager, Container $container)
{
    //Block Bindings Sources
    try {
        $blockBindingsSourceService = $manager->getService(ServiceInterface::BLOCK_BINDINGS_SOURCE_SERVICE_NAME);
        if ($blockBindingsSourceService instanceof BlockBindingsSourceServiceInterface) {
            $blockBindingsSourceService->registerBlockBindingsSources();
        }
    } catch (ServiceNotFoundException $e) {
        if ($e->getServiceType() === ServiceInterface::BLOCK_BINDINGS_SOURCE_SERVICE_NAME) {
            //No block bindings source service found, use the default one instead
            $blockBindingsSourceService = $container['wwp.blockBindingsSource.defaultService'];
            if ($blockBindingsSourceService instanceof BlockBindingsSourceServiceInterface) {
                if ($blockBindingsSourceService instanceof ManagerAwareInterface) {
                    $blockBindingsSourceService->setManager($manager);
                }
                $blockBindingsSourceService->register();
            }
        } else {
            throw $e;
        }
    }
} 