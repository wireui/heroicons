<?php

namespace Tests\Unit\HeroiconsServiceProvider;

use Illuminate\View\Compilers\BladeCompiler;
use Tests\TestCase;

class DontRegisterIconComponentAliasTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('wireui.heroicons.alias', false);
    }

    public function test_should_not_register_the_icon_component()
    {
        /** @var BladeCompiler $bladeCompiler */
        $bladeCompiler = resolve(BladeCompiler::class);

        $aliases = $bladeCompiler->getClassComponentAliases();

        $this->assertArrayNotHasKey('custom-icon', $aliases, "The custom alias shouldn't be registered");
    }
}
