<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\{Collection, Str};
use Symfony\Component\Finder\{Finder, SplFileInfo};
use WireUi\Heroicons\Icon;

function getIcons(string $variant): Collection
{
    $files = (new Finder())->files()->in(__DIR__ . "/../../src/views/icons/{$variant}");

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

    expect($view->name())->toEndWith('icons.outline.home');
    expect($parsedStyle)->toBe('outline');
});

it('should make the solid icon blade view', function () {
    $icon = new Icon(name: 'home', solid: true);

    $view = $icon->render();

    $parsedStyle = $this->invokeMethod($icon, 'getVariant');

    expect($view->name())->toEndWith('icons.solid.home');
    expect($parsedStyle)->toBe('solid');
});

it('should get the correct icon variant', function (string $expected, Icon $icon) {
    $parsedStyle = $this->invokeMethod($icon, 'getVariant');

    expect($parsedStyle)->toBe($expected);
    expect($icon->variant)->toBe($expected);

    $view = $icon->render();
    expect($view->name())->toEndWith("icons.{$icon->variant}.home");
})->with([
    ['outline', new Icon(name: 'home', variant: 'outline')],
    ['outline', new Icon(name: 'home', outline: true)],
    ['solid',   new Icon(name: 'home', solid: true)],
]);

it('should render all components with attributes', function (string $icon, string $variant) {
    $html = Blade::render('<x-icon :name="$name" :variant="$variant" class="w-5 h-5" style="foo: bar" />', [
        'name'    => $icon,
        'variant' => $variant,
    ]);

    $view = (new Icon(name: $icon, variant: $variant))->render();

    expect($view->name())->toBe("wireui.heroicons::icons.{$variant}.{$icon}");

    expect($html)
        ->toContain('<svg')
        ->toContain('</svg>')
        ->toContain('class="w-5 h-5"')
        ->toContain('style="foo: bar"');
})->with(
    collect()
        ->push(getIcons('outline'))
        ->push(getIcons('solid'))
        ->collapse()
        ->toArray()
);
