<?php

namespace AndrykVP\Rancor\Package\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Color to use when displaying alert
     * 
     * @var string
     */
    public $color;
    
    /**
     * Message to display in alert component
     * 
     * @var string
     */
    public $message;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Array $alert)
    {
        $this->message = $alert['message'];
        $this->color = $alert['color'];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('rancor::components.alert');
    }
}
