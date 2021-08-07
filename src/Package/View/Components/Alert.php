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
     * Miliseconds to keep the Alet alive
     * 
     * @var integer
     */
    public $timeout;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Array $alert, String $color = 'green', $timeout = 3500)
    {
        $this->message = $this->buildMessage((object) $alert);
        $this->color = $color;
        $this->timeout = $timeout;
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

    /**
     * Builds the rendered Message from Model
     * 
     * @return string
     */
    private function buildMessage(Object $alert)
    {
        $message = '';

        if(property_exists($alert, 'model') && $alert->model != null)
        {
            $message .= $alert->model.' ';
        }
        if(property_exists($alert, 'name') && $alert->name != null)
        {
            $message .= '"'.$alert->name.'" ';
        }
        if(property_exists($alert, 'id') && $alert->id != null)
        {
            $message .= '(#'.$alert->id.') ';
        }
        
        $message .= 'has been successfully '.$alert->action;

        return $message;
    }
}
