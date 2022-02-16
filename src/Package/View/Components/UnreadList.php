<?php

namespace Rancor\Package\View\Components;

use Illuminate\View\Component;

class UnreadList extends Component
{
	/**
	 * The Discussions to render
	 *
	 * @var array|mixed
	 */
	public $discussions;


	/**
	 * Create a new component instance.
	 *
	 * @return void
	 */
	public function __construct($discussions)
	{
		$this->discussions = $discussions;
	}

	/**
	 * Get the view / contents that represent the component.
	 *
	 * @return \Illuminate\Contracts\View\View|string
	 */
	public function render()
	{
		return view('rancor::components.unreadlist');
	}
}
