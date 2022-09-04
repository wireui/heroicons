<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\{Factory, FileViewFinder};

it('should register the views path', function () {
    /** @var Factory $view */
    $view = View::getFacadeRoot();

    /** @var FileViewFinder $finder */
    $finder = $view->getFinder();
    expect($finder->getHints())->toHaveKey('heroicons');
    expect($finder->getHints()['heroicons'][0])->toContain('src/views');
});

it('should merge the wireui.heroicons config', function () {
    expect(config('wireui.heroicons'))->toHaveKeys([
        'variant',
        'alias',
    ]);
});

it('should add the publish groups', function () {
    $publishGroups = ServiceProvider::$publishGroups;

    expect($publishGroups)->toHaveKeys([
        'wireui.heroicons.config',
        'wireui.heroicons.views',
    ]);

    expect($publishGroups['wireui.heroicons.config'])->toBeArray()->toHaveCount(1);
    expect($publishGroups['wireui.heroicons.views'])->toBeArray()->toHaveCount(1);

    expect(array_key_first($publishGroups['wireui.heroicons.config']))->toBeFile();
    expect(array_key_first($publishGroups['wireui.heroicons.views']))->toBeDirectory();

    expect(array_values($publishGroups['wireui.heroicons.config'])[0])->toEndWith('config/wireui/heroicons.php');
    expect(array_values($publishGroups['wireui.heroicons.views'])[0])->toEndWith('resources/views/vendor/wireui/heroicons');
});

it('should register the blade components', function () {
    /** @var BladeCompiler $bladeCompiler */
    $bladeCompiler = resolve(BladeCompiler::class);

    expect($bladeCompiler->getClassComponentAliases())->toHaveKey('icon');
});
