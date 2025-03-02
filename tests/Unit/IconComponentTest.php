<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\{Collection, Str};
use Symfony\Component\Finder\{Finder, SplFileInfo};
use WireUi\Heroicons\Icon;

function getIcons(string $variant): Collection
{
    $iconsPath = str_replace('.', '/', $variant);

    $files = (new Finder())->files()->in(__DIR__ . "/../../src/views/components/{$iconsPath}");

    return collect($files)->map(fn (SplFileInfo $file) => [
        'icon'    => Str::before($file->getFilename(), '.blade.php'),
        'variant' => $variant,
    ]);
}

it('should get the default icon variant', function () {
    $icon = new Icon(name: 'house');

    $parsedStyle = $this->invokeMethod($icon, 'getVariant');

    expect($parsedStyle)->toBe('outline');
});

it('should make the outline icon blade view', function () {
    $icon = new Icon(name: 'home', outline: true);

    $view = $icon->render();

    $parsedStyle = $this->invokeMethod($icon, 'getVariant');

    expect($view->name())->toEndWith('components.outline.home');
    expect($parsedStyle)->toBe('outline');
});

it('should make the solid icon blade view', function () {
    $icon = new Icon(name: 'home', solid: true);

    $view = $icon->render();

    $parsedStyle = $this->invokeMethod($icon, 'getVariant');

    expect($view->name())->toEndWith('components.solid.home');
    expect($parsedStyle)->toBe('solid');
});

it('should get the correct icon variant', function (string $expected, Icon $icon) {
    $parsedStyle = $this->invokeMethod($icon, 'getVariant');

    expect($parsedStyle)->toBe($expected);
    expect($icon->variant)->toBe($expected);

    $view = $icon->render();
    expect($view->name())->toEndWith("components.{$icon->variant}.home");
})->with([
    ['outline', new Icon(name: 'home', variant: 'outline')],
    ['outline', new Icon(name: 'home', outline: true)],
    ['solid', new Icon(name: 'home', solid: true)],
    ['mini.solid', new Icon(name: 'home', variant: 'mini', mini: true)],
    ['mini.solid', new Icon(name: 'home', mini: true)],
    ['micro.solid', new Icon(name: 'home', variant: 'micro', micro: true)],
    ['micro.solid', new Icon(name: 'home', micro: true)],
]);

it('should inject the mini variant when it is given', function () {
    $icon = new Icon(name: 'home', solid: true, mini: true);

    $variant = $this->invokeMethod($icon, 'getVariant');

    expect($variant)->toEndWith('mini.solid');
});

it('should inject the micro variant when it is given', function () {
    $icon = new Icon(name: 'home', solid: true, micro: true);

    $variant = $this->invokeMethod($icon, 'getVariant');

    expect($variant)->toEndWith('micro.solid');
});

it('should render all variant icons', function (string $variant) {
    foreach (getIcons($variant) as $data) {
        $icon = $data['icon'];

        $iconVariant = str_replace('/', '.', $variant);

        $html = Blade::render(<<<BLADE
            <x-icon name="{$icon}" variant="{$iconVariant}" class="w-5 h-5" style="foo: bar" />
            <x-heroicons::{$iconVariant}.{$icon} class="w-10 h-10" />
        BLADE);

        $view = (new Icon(name: $icon, variant: $iconVariant))->render();

        $expected = Str::replace('/', '.', "heroicons::components.{$iconVariant}.{$icon}");

        expect($view->name())->toBe($expected)
            ->and($html)
            ->toContain('<svg')
            ->toContain('</svg>')
            ->toContain('class="w-5 h-5"')
            ->toContain('style="foo: bar"')
            ->toContain('class="w-10 h-10"')
            ->not->toContain('<x-heroicons')
            ->not->toContain('<x-icon');
    }
})->with([
    'outline',
    'solid',
    'mini.solid',
    'micro.solid',
]);
