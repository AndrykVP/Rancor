<?php

namespace Rancor\Package\View\Components;

use Illuminate\View\Component;

class MainNavigation extends Component
{
   /**
    * Get the view / contents that represent the component.
    *
    * @return \Illuminate\Contracts\View\View|string
    */
   public function render()
   {
      return view('rancor::components.mainnavigation');
   }
}
