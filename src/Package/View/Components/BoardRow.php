<?php

namespace Rancor\Package\View\Components;

use Illuminate\View\Component;
use Rancor\Forums\Models\Board;

class BoardRow extends Component
{
	/**
	 * The Categoy to render
	 *
	 * @var  \Rancor\Forums\Models\Board
	 */
	public $board;

	/**
	 * The Total number of Unread Replies
	 *
	 * @var int
	 */
	 public $unread_replies;

	/**
	 * Create a new component instance.
	 *
	 * @return void
	 */
	public function __construct(Board $board, Int $unreadReplies)
	{
		$this->board = $board;
		$this->unread_replies = $unreadReplies;
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
