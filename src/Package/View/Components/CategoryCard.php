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
    * The Collection of Unread Discussions
    *
    * @var  \Illuminate\Support\Collection
    */
   public $unread_discussions;

   /**
    * Create a new component instance.
    *
    * @return void
    */
   public function __construct(Category $category, $unreadDiscussions)
   {
      $this->category = $category;
      $this->unread_discussions = $unreadDiscussions;
   }

   /**
    * Get the view / contents that represent the component.
    *
    * @return \Illuminate\Contracts\View\View|string
    */
   public function render()
   {
      return view('rancor::components.categorycard');
   }
}
