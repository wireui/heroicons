<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\{Collection, Str};
use Symfony\Component\Finder\{Finder, SplFileInfo};
use WireUi\Heroicons\Icon;

function getIcons(string $variant): Collection
{
    $files = (new Finder())->files()->in(__DIR__ . "/../../src/views/components/{$variant}");

    return collect($files)->map(fn (SplFileInfo $file) => [
        'icon'    => Str::before($file->getFilename(), '.blade.php'),
        'variant' => $variant,
    ]);
}

it('should get the correct icon style', function ($expected, $name, $style, $solid, $outline) {
    $component = new Icon($name, $style, $solid, $outline);

    $parsedStyle = $this->invokeMethod($component, 'getVariantStyle');

    expect($parsedStyle)->toBe($expected);
})->with([
    ['solid', 'home', 'solid', false, false],
    ['solid', 'home', null, true, false],
    ['outline', 'home', null, false, true],
    ['outline', 'home', null, false, false],
]);

it('should render all components', function (string $icon, string $variant) {
    $html = Blade::render('<x-icon :name="$name" :variant="$variant" />', [
        'name'    => $icon,
        'variant' => $variant,
    ]);

    expect($html)->toContain('<svg');
    expect($html)->toContain('</svg>');
})->with(function () {
    return collect([
        getIcons('solid'),
        getIcons('outline'),
    ])->collapse()->toArray();
});

it('should render all attributes into the component', function (string $icon, string $variant) {
    $html = Blade::render('<x-icon :name="$name" :variant="$variant" class="w-5 h-5" style="foo: bar" />', [
        'name'    => $icon,
        'variant' => $variant,
    ]);

    expect($html)->toContain('class="w-5 h-5"');
    expect($html)->toContain('style="foo: bar"');
})->with(function () {
    return collect([
        getIcons('solid'),
        getIcons('outline'),
    ])->collapse()->toArray();
});
