<?php

namespace AndrykVP\Rancor\Package\View\Components;

use Illuminate\View\Component;

class ScannerTable extends Component
{    
   /**
    * Message to display in alert component
    * 
    * @var object  Illuminate/Collection
    */
   public $entries;

   /**
    * Create a new component instance.
    *
    * @return void
    */
   public function __construct($entries)
   {
      $this->entries = $entries;
   }

   /**
    * Get the view / contents that represent the component.
    *
    * @return \Illuminate\Contracts\View\View|string
    */
   public function render()
   {
      return view('rancor::components.scannertable');
   }
}
