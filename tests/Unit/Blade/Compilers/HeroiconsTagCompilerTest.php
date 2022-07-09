<?php

use WireUi\Heroicons\Blade\Compilers\HeroiconsTagCompiler;

it('should process the heroicons tag compiler', function (string $component, string $expected) {
    $compiler = resolve(HeroiconsTagCompiler::class);

    expect($expected)->toBe($compiler->compile($component));
})->with([
    [
        'component' => '<x-icons.heroicons.user></x-icons.heroicons.user>',
        'expected'  => '<x-icons.heroicons name="user" />',
    ],
    [
        'component' => '<x-icons.heroicons.user></x-icons.heroicons.user>',
        'expected'  => '<x-icons.heroicons name="user" />',
    ],
    [
        'component' => '<x-icons.heroicons.user-group ></x-icons.heroicons.user-group>',
        'expected'  => '<x-icons.heroicons name="user-group"  />',
    ],
    [
        'component' => '<x-icons.heroicons.outline.user></x-icons.heroicons.outline.user>',
        'expected'  => '<x-icons.heroicons name="user" variant="outline"  />',
    ],
    [
        'component' => '<x-icons.heroicons.solid.user></x-icons.heroicons.solid.user>',
        'expected'  => '<x-icons.heroicons name="user" variant="solid"  />',
    ],
    [
        'component' => '<x-icons.heroicons.user solid></x-icons.heroicons.user>',
        'expected'  => '<x-icons.heroicons name="user" solid />',
    ],
    [
        'component' => '<x-icons.heroicons.user outline></x-icons.heroicons.user>',
        'expected'  => '<x-icons.heroicons name="user" outline />',
    ],
    [
        'component' => '<x-icons.heroicons.user class="w-5 h-5"></x-icons.heroicons.user>',
        'expected'  => '<x-icons.heroicons name="user" class="w-5 h-5" />',
    ],
    [
        'component' => <<<HTML
        <x-icons.heroicons.user
            class="w-5 h-5"
            style="border: 1px solid red"
        >
        </x-icons.heroicons.user>
        HTML,
        'expected' => <<<HTML
        <x-icons.heroicons name="user"
            class="w-5 h-5"
            style="border: 1px solid red"
         />

        HTML
    ],
    [
        'component' => <<<HTML
        <x-icons.heroicons.user
            class="w-5 h-5"
            style="
                border: 1px solid red;
                color: green;
            "
            foo="bar"
            baz
            x-alpine
         ></x-icons.heroicons.user>
        HTML,
        'expected' => <<<HTML
        <x-icons.heroicons name="user"
            class="w-5 h-5"
            style="
                border: 1px solid red;
                color: green;
            "
            foo="bar"
            baz
            x-alpine
          />
        HTML
    ],
    [
        'component' => <<<HTML
        <x-icons.heroicons.user class="w-5 h-5"

         ></x-icons.heroicons.user>
        HTML,
        'expected' => <<<HTML
        <x-icons.heroicons name="user" class="w-5 h-5"

          />
        HTML
    ],
    [
        'component' => '<x-icons.heroicons.user />',
        'expected'  => '<x-icons.heroicons name="user" />',
    ],
    [
        'component' => '<x-icons.heroicons.user-group />',
        'expected'  => '<x-icons.heroicons name="user-group" />',
    ],
    [
        'component' => '<x-icons.heroicons.outline.user />',
        'expected'  => '<x-icons.heroicons name="user" variant="outline"  />',
    ],
    [
        'component' => '<x-icons.heroicons.solid.user />',
        'expected'  => '<x-icons.heroicons name="user" variant="solid"  />',
    ],
    [
        'component' => '<x-icons.heroicons.user solid />',
        'expected'  => '<x-icons.heroicons name="user" solid  />',
    ],
    [
        'component' => '<x-icons.heroicons.user outline />',
        'expected'  => '<x-icons.heroicons name="user" outline  />',
    ],
    [
        'component' => '<x-icons.heroicons.user class="w-5 h-5" />',
        'expected'  => '<x-icons.heroicons name="user" class="w-5 h-5"  />',
    ],
    [
        'component' => <<<HTML
        <x-icons.heroicons.user
            class="w-5 h-5"
            style="border: 1px solid red"
        />
        HTML,
        'expected' => <<<HTML
        <x-icons.heroicons name="user" class="w-5 h-5"
            style="border: 1px solid red"
         />
        HTML
    ],
    [
        'component' => <<<HTML
        <x-icons.heroicons.user
            class="w-5 h-5"
            style="
                border: 1px solid red;
                color: green;
            "
            foo="bar"
            baz
            x-alpine
        />
        HTML,
        'expected' => <<<HTML
        <x-icons.heroicons name="user" class="w-5 h-5"
            style="
                border: 1px solid red;
                color: green;
            "
            foo="bar"
            baz
            x-alpine
         />
        HTML
    ],
    [
        'component' => <<<HTML
        <x-icons.heroicons.user class="w-5 h-5"

         />
        HTML,
        'expected' => <<<HTML
        <x-icons.heroicons name="user" class="w-5 h-5"

          />
        HTML
    ],
]);
