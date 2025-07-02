<?php

namespace WonderWp\Component\BlockBindingsSource\Service;

use WonderWp\Component\BlockBindingsSource\Definition\BlockBindingsSourceInterface;
use WonderWp\Component\PluginSkeleton\ManagerAwareTrait;

class BlockBindingsSourceService extends AbstractBlockBindingsSourceService
{
    use ManagerAwareTrait;

    public function register()
    {
        add_action('init', function() {
            $autoLoaded = $this->autoload();
        }, 9);
    }

    public function autoload(array $classNameFromFiles = [], array $discoveryPaths = [], callable $successCallback = null, array $excludedClasses = []): array
    {
        $discoveryPathsRoots = $this->manager->getConfig('discoveryPathsRoots', [
            'block-bindings-source' => rtrim($this->manager->getConfig('path.root') ?? '', DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR
        ]);
        $discoverFolderSuffix = $this->manager->getConfig('blockBindingsSourceService.discoverFolderSuffix', 'BlockBindingsSources');
        $defaultPaths = $this->deductDefaultDiscoveryPaths($discoveryPathsRoots, $discoverFolderSuffix);
        $discoveryPaths = array_merge($defaultPaths, $discoveryPaths);

        $autoLoaded = parent::autoload($classNameFromFiles, $discoveryPaths, $successCallback);

        if (!empty($this->blockBindingsSources)) {
            $this->registerBlockBindingsSources();
        }

        return $autoLoaded;
    }

    protected function autoloadFile(string $className, string $filePath): object
    {
        $instance = parent::autoloadFile($className, $filePath);

        if($instance instanceof BlockBindingsSourceInterface) {
            $this->addBlockBindingsSource($instance);
        }

        return $instance;
    }
}
