<?php

namespace WireUi\Heroicons;

use Illuminate\Contracts\View\{Factory, View};
use Illuminate\View\Component;

class Icon extends Component
{
    public function __construct(
        public string $name,
        public ?string $variant = null,
        public bool $solid = false,
        public bool $outline = false,
    ) {
        $this->variant = $this->getVariant();
    }

    public function render(): View|Factory
    {
        return view("wireui.heroicons::icons.{$this->variant}.{$this->name}");
    }

    private function getVariant(): string
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

        return config('wireui.heroicons.variant');
    }
}
