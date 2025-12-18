<?php

namespace WonderWp\Component\BlockBindingsSource\Traits;

trait HasBlockBindingsSourceAutoloader
{
    /**
     * Customize discovery paths for block bindings sources.
     *
     * @param array $discoveryPaths
     * @return array
     */
    protected function resolveDiscoveryPaths(array $discoveryPaths): array
    {
        $discoveryPathsRoots = $this->manager->getConfig('discoveryPathsRoots', [
            'block-bindings-source' => rtrim($this->manager->getConfig('path.root') ?? '', DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR,
        ]);

        $discoverFolderSuffix = $this->manager->getConfig('blockBindingsSourceService.discoverFolderSuffix', 'BlockBindingsSources');
        $defaultPaths         = $this->deductDefaultDiscoveryPaths($discoveryPathsRoots, $discoverFolderSuffix);

        return array_merge($defaultPaths, $discoveryPaths);
    }

    /**
     * After autoloading, register discovered block bindings sources.
     *
     * @param array    $result
     * @param array    $classNameFromFiles
     * @param array    $discoveryPaths
     * @param callable $successCallback
     * @param array    $excludedClasses
     *
     * @return array
     */
    protected function afterAutoload(
        array $result,
        array $classNameFromFiles,
        array $discoveryPaths,
        callable $successCallback,
        array $excludedClasses
    ): array {
        if (!empty($this->blockBindingsSources)) {
            $this->registerBlockBindingsSources();
        }

        return $result;
    }
}


