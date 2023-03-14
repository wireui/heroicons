<?php

namespace WireUi\Heroicons;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class HeroiconsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerConfig();
        $this->registerBladeComponents();
    }

    protected function registerConfig(): void
    {
        $rootDir = __DIR__;

        $this->loadViewsFrom("{$rootDir}/views", 'heroicons');
        $this->mergeConfigFrom("{$rootDir}/config.php", 'wireui.heroicons');
        $this->publishes(
            ["{$rootDir}/config.php" => config_path('wireui/heroicons.php')],
            'wireui.heroicons.config',
        );
        $this->publishes(
            ["{$rootDir}/views" => resource_path('views/vendor/wireui/heroicons')],
            'wireui.heroicons.views',
        );
    }

    protected function registerBladeComponents(): void
    {
        if (!config('wireui.heroicons.alias')) {
            return;
        }

        $this->callAfterResolving(BladeCompiler::class, static function (BladeCompiler $blade): void {
            /** @var string $alias */
            $alias = config('wireui.heroicons.alias');
            $blade->component(Icon::class, $alias);
        });
    }
}
