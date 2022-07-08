<?php

namespace WireUi\Heroicons;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class HeroiconsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerConfig();
        $this->registerBladeComponents();
    }

    protected function registerConfig(): void
    {
        $rootDir = __DIR__;

        $this->loadViewsFrom("{$rootDir}/views", 'wireui.heroicons');
        $this->mergeConfigFrom("{$rootDir}/config.php", 'wireui.heroicons');
        $this->publishes(
            ["{$rootDir}/config.php" => config_path('wireui/heroicons.php')],
            'wireui.heroicons.config'
        );
        $this->publishes(
            ["{$rootDir}/views" => resource_path('views/vendor/wireui/heroicons')],
            'wireui.heroicons.resources'
        );
    }

    protected function registerBladeComponents(): void
    {
        $this->callAfterResolving(BladeCompiler::class, static function (BladeCompiler $blade): void {
            $blade->component(Icon::class, config('wireui.heroicons.alias'));
        });
    }
}
