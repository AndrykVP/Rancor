<?php

namespace Rancor\Forums\Traits;
use Rancor\Forums\Models\Board;
use Rancor\Forums\Models\Category;
use Rancor\Forums\Models\Discussion;
use Rancor\Forums\Models\Group;
use Rancor\Forums\Models\Reply;

trait ForumUser
{
	/**
	 * Relationship to Group model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function groups()
	{
		return $this->morphToMany(Group::class,'groupable','forum_groupables')->withTimestamps();
	}

	/**
	 * Relationship to Board model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function boards()
	{
		return $this->belongsToMany(Board::class, 'forum_moderators')->withTimestamps();
	}

	/**
	 * Relationship to Board model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function discussions()
	{
		return $this->belongsToMany(Discussion::class, 'forum_unread_discussions')
				->withTimestamps()
				->as('unread')
				->withPivot('reply_count')
				->wherePivot('reply_count', '>', 0)
				->latest('updated_at');
	}

	/**
	 * Relationship to Board model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function replies()
	{
		return $this->hasMany(Reply::class, 'created_by')->latest();
	}

	/**
	 * List of IDs from Board model that User has access to
	 * 
	 * @return array
	 */
	public function topics()
	{
		if($this->hasPermission('view-forum-boards'))
		{
			return Board::select('id')->get()->pluck('id')->sort()->values();
		}

		return $this->visibleBoards()->pluck('id')->unique()->sort()->values();
	}

	/**
	 * List of IDs from Category model that User has access to
	 * 
	 * @return array
	 */
	public function categories()
	{
		if($this->hasPermission('view-forum-categories'))
		{
			return Category::select('id')->get()->pluck('id')->sort()->values();
		}

		return $this->visibleBoards()->pluck('category_id')->unique()->sort()->values();
	}

	/**
	 * Function to retrieve all Boards that the User can see
	 * 
	 * @return Illuminate\Support\Collection
	 */
	private function visibleBoards()
	{
		return $this->groups->pluck('boards')->merge($this->boards)->flatten();
	}
}
