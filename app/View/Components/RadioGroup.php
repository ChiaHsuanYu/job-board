<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RadioGroup extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public array $options,
        public ?bool $allOption = true,
        public ?string $value = null
    )
    {
        //
    }

    public function optionsWithLabels(): array{
        if (is_array($this->options) && (count($this->options)>0))
            return array_combine(
                array_map('ucfirst', array_keys($this->options)),array_values($this->options)
            );
        else
            return $this->options;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.radio-group');
    }
}
