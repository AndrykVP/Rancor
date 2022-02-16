<?php

namespace Rancor\Forums\Observers;

use Illuminate\Support\Facades\DB;
use Rancor\Forums\Models\Board;

class BoardObserver
{
	/**
	 * Handle the Board "creating" event
	 *
	 * @param \Rancor\Forums\Models\Board  $board
	 * @return void
	 */
	public function creating(Board $board)
	{
		$maxLineup = DB::table('forum_boards')
						->where('category_id', $board->category_id)
						->max('lineup') ?? 0;
		if(is_null($board->lineup) || $board->lineup > ($maxLineup + 1))
		{
			$board->lineup = $maxLineup + 1;
		}

		$lowerBoards = DB::table('forum_boards')
								->select('id')
								->where('category_id', $board->category_id)
								->where('lineup', '>=', $board->lineup)
								->get()
								->pluck('id')
								->toArray();

		$this->increment_lineup($lowerBoards);
	}

	/**
	 * Handle the Board "updating" event
	 *
	 * @param \Rancor\Forums\Models\Board  $board
	 * @return void
	 */
	public function updating(Board $board)
	{
		if($board->isClean('lineup') && $board->isClean('category_id')) return;

		$maxLineup = DB::table('forum_boards')
						->where('id', '!=', $board->id)
						->where('category_id', $board->category_id)
						->max('lineup') ?? 0;
		if(is_null($board->lineup) || $board->lineup > ($maxLineup + 1))
		{
			$board->lineup = $maxLineup + 1;
		}
		
		if($board->isDirty('lineup') && $board->isClean('category_id'))
		{
			$lineupRange = [
				$board->getOriginal('lineup'), $board->lineup
			];
			if($board->getOriginal('lineup') > $board->lineup)
			{
				$lineupRange = array_reverse($lineupRange);
			} 
	
			$lowerBoards = DB::table('forum_boards')
									->select('id')
									->where('id', '!=', $board->id)
									->where('category_id', $board->category_id)
									->whereBetween('lineup', $lineupRange)
									->get()
									->pluck('id')
									->toArray();
	
			if($board->getOriginal('lineup') < $board->lineup) $this->decrement_lineup($lowerBoards);
			else $this->increment_lineup($lowerBoards);
		}

		if($board->isDirty('category_id'))
		{
			$lowerNewBoards = DB::table('forum_boards')
									->select('id')
									->where('id', '!=', $board->id)
									->where('category_id', $board->category_id)
									->where('lineup', '>=', $board->lineup)
									->get()
									->pluck('id')
									->toArray();

			$lowerOldBoards = DB::table('forum_boards')
									->select('id')
									->where('id', '!=', $board->id)
									->where('category_id', $board->getOriginal('category_id'))
									->where('lineup', '>=', $board->getOriginal('lineup'))
									->get()
									->pluck('id')
									->toArray();

									
			$this->decrement_lineup($lowerOldBoards);
			$this->increment_lineup($lowerNewBoards);
		}
	}

	/**
	 * Handle the Board "deleted" event
	 *
	 * @param \Rancor\Forums\Models\Board  $board
	 * @return void
	 */
	public function deleted(Board $board)
	{
		$lowerBoards = DB::table('forum_boards')
								->select('id')
								->where('id', '!=', $board->id)
								->where('category_id', $board->category_id)
								->where('lineup', '>', $board->lineup)
								->get()
								->pluck('id')
								->toArray();

		$this->decrement_lineup($lowerBoards);
	}

	/**
	 * Function to increment Board lineup in case of addition
	 *
	 * @param array  $board_ids
	 */
	private function increment_lineup(Array $board_ids)
	{
		DB::table('forum_boards')
		->whereIn('id', $board_ids)
		->increment('lineup');
	}

	/**
	 * Function to decrement Board lineup in case of removal
	 *
	 * @param array  $board_ids
	 */
	private function decrement_lineup(Array $board_ids)
	{
		DB::table('forum_boards')
		->whereIn('id', $board_ids)
		->decrement('lineup');
	}
}