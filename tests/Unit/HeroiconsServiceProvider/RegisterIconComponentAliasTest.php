<?php

namespace Tests\Unit\HeroiconsServiceProvider;

use Illuminate\View\Compilers\BladeCompiler;
use Tests\UnitTestCase;

class RegisterIconComponentAliasTest extends UnitTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('wireui.heroicons.alias', 'custom-icon');
    }

    public function test_should_register_the_icon_blade_component_with_a_custom_alias()
    {
        /** @var BladeCompiler $bladeCompiler */
        $bladeCompiler = resolve(BladeCompiler::class);

        $aliases = $bladeCompiler->getClassComponentAliases();

        $this->assertArrayHasKey('custom-icon', $aliases, 'The custom alias should be registered');
        $this->assertSame($aliases['custom-icon'], 'WireUi\Heroicons\Icon');
    }
}
