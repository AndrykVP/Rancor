<?php

namespace AndrykVP\Rancor\Package\View\Components;

use Illuminate\View\Component;

class DiscussionList extends Component
{
   /**
    * The Categoy to render
    *
    * @var array|mixed
    */
   public $discussions;

   /**
    * Header for the rendered Card
    *
    * @var string
    */
   public $title;

   /**
    * Create a new component instance.
    *
    * @return void
    */
   public function __construct($discussions, $title)
   {
      $this->discussions = $discussions;
      $this->title = $title;
   }

   /**
    * Get the view / contents that represent the component.
    *
    * @return \Illuminate\Contracts\View\View|string
    */
   public function render()
   {
      return view('rancor::components.discussionlist');
   }
}
