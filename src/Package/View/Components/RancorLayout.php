<?php

namespace AndrykVP\Rancor\Package\View\Components;

use Illuminate\View\Component;

class RancorLayout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('rancor::layouts.rancor');
    }
}
