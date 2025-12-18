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

    protected function autoloadFile(string $className, string $filePath): object
    {
        $instance = parent::autoloadFile($className, $filePath);

        if($instance instanceof BlockBindingsSourceInterface) {
            $this->addBlockBindingsSource($instance);
        }

        return $instance;
    }
}
