<?php

namespace Rancor\Package\View\Components;

use Illuminate\View\Component;

class DiscussionList extends Component
{
	/**
	 * The Discussion's Category
	 *
	 * @var array|mixed
	 */
	public $category;

	/**
	 * The Discussion's Board
	 *
	 * @var array|mixed
	 */
	public $board;

	/**
	 * The Discussions to render
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
	public function __construct($discussions, $title, $board, $category)
	{
		$this->category = $category;
		$this->discussions = $discussions;
		$this->board = $board;
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
