<?php

namespace AndrykVP\Rancor\Package\View\Components;

use Illuminate\View\Component;
use AndrykVP\Rancor\Forums\Models\Category;

class CategoryCard extends Component
{
   /**
    * The Categoy to render
    *
    * @var  \AndrykVP\Rancor\Forums\Models\Category
    */
   public $category;

   /**
    * Create a new component instance.
    *
    * @return void
    */
   public function __construct(Category $category)
   {
      $this->category = $category;
   }

   /**
    * Get the view / contents that represent the component.
    *
    * @return \Illuminate\Contracts\View\View|string
    */
   public function render()
   {
      // return view('rancor::components.categorycard');

      return 'Hello World';
   }
}
