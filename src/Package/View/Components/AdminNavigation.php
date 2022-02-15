<?php

namespace Rancor\Package\View\Components;

use Illuminate\View\Component;

class AdminNavigation extends Component
{
   /**
    * Links received from Admin Layout
    *
    * @var array
    */
    public $links;

   /**
    * Create a new component instance.
    *
    * @return void
    */
   public function __construct(Object $links)
   {
      $this->links = $links;
   }

   /**
    * Get the view / contents that represent the component.
    *
    * @return \Illuminate\Contracts\View\View|string
    */
   public function render()
   {
      return view('rancor::components.adminnavigation');
   }
}
