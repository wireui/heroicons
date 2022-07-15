<?php

return [
    /*
        |--------------------------------------------------------------------------
        | Icons Variants
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
        | Set to false to disable the component.
        | <x-icon ... />
        |
    */
    'alias' => env('WIREUI_HEROICONS_ALIAS', 'icon'),
];
