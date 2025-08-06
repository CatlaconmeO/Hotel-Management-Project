<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DisplayItem extends Component
{
    public $label;
    public $value;

    /**
     * Create a new component instance.
     *
     * @param  string  $label
     * @param  string|null  $value
     * @return void
     */
    public function __construct($label, $value = null)
    {
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.display-item');
    }
}
