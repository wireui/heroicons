<?php

return [
    /*
        |--------------------------------------------------------------------------
        | Icons Variant
        |--------------------------------------------------------------------------
        |
        | The icon variant can be 'solid' or 'outline'
        | <x-icon solid />
        | <x-icon outline />
        | <x-icon variant="outline" />
        |
    */
    'variant' => env('WIREUI_HEROICONS_VARIANT', 'outline'),

    /*
        |--------------------------------------------------------------------------
        | Icon component alias
        |--------------------------------------------------------------------------
        |
        | The component alias to import in the blade/livewire component
        | <x-icon ... />
        |
    */
    'alias' => env('WIREUI_HEROICONS_ALIAS', 'icon'),
];
