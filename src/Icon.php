<?php

namespace WireUi\Heroicons;

use Illuminate\View\Component;

class Icon extends Component
{
    public function __construct(
        public string $name,
        public ?string $variant = null,
        public bool $solid = false,
        public bool $outline = false,
    ) {
        $this->variant = $this->getVariantStyle();
    }

    public function render()
    {
        return view('wireui.heroicons::components.icon');
    }

    private function getVariantStyle(): string
    {
        if ($this->variant) {
            return $this->variant;
        }

        if ($this->solid) {
            return 'solid';
        }

        if ($this->outline) {
            return 'outline';
        }

        return config('wireui.heroicons.style');
    }
}
