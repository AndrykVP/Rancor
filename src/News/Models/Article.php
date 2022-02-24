<?php

namespace Rancor\News\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Rancor\DB\Factories\ArticleFactory;
use Rancor\Package\Traits\Userstamps;

class Article extends Model
{
	use HasFactory, Userstamps;
	
	/**
	 * Defines the table name
	 * 
	 * @var string
	 */
	protected $table = 'news_articles';

	/**
	 * Attributes available for mass assignment
	 * 
	 * @var array
	 */
	protected $fillable = [ 'name', 'body', 'description', 'is_published', 'published_at' ];

	/**
	 * Attributes casted to native types
	 * 
	 * @var array
	 */
	protected $casts = [
		'is_published' => 'boolean',
		'published_at' => 'datetime',
	];

	/**
	 * Defines the table name
	 * 
	 * @var string
	 */
	protected $hidden = ['pivot'];

	/**
	 * Relationship to User model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function author()
	{
		return $this->belongsTo(User::class, 'created_by');
	}

	/**
	 * Relationship to User model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function editor()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

	/**
	 * Relationship to Tag model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function tags()
	{
		return $this->belongsToMany(Tag::class, 'news_article_tag')->withTimestamps();
	}


	/**
	 * Scope a query to include discussions by their is_published status.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder  $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopePublished($query, $value = true)
	{
		return $query->where('is_published', $value);
	}
	
	/**
	 * Create a new factory instance for the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Factories\Factory
	 */
	protected static function newFactory()
	{
		return ArticleFactory::new();
	}
}
