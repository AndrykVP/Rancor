<?php

namespace AndrykVP\Rancor\Package\View\Components;

use Illuminate\View\Component;
use AndrykVP\Rancor\Forums\Models\Board;

class BoardRow extends Component
{
   /**
    * The Categoy to render
    *
    * @var  \AndrykVP\Rancor\Forums\Models\Board
    */
   public $board;

   /**
    * Create a new component instance.
    *
    * @return void
    */
   public function __construct(Board $board)
   {
      $this->board = $board;
   }

   /**
    * Get the view / contents that represent the component.
    *
    * @return \Illuminate\Contracts\View\View|string
    */
   public function render()
   {
      return view('rancor::components.boardrow');
   }
}
