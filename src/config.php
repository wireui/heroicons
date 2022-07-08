<?php

return [
    /*
        |--------------------------------------------------------------------------
        | Icons Style
        |--------------------------------------------------------------------------
        |
        | The icon style can be 'solid' or 'outline'
        | <x-icon solid />
        | <x-icon outline />
        | <x-icon variant="outline" />
        |
    */
    'style' => env('WIREUI_HEROICONS_STYLE', 'outline'),

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
