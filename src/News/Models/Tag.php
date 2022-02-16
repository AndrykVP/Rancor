<?php

namespace Rancor\News\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Rancor\DB\Factories\TagFactory;

class Tag extends Model
{
	use HasFactory;
	
	/**
	 * Defines the table name
	 * 
	 * @var string
	 */
	protected $table = 'news_tags';

	/**
	 * Attributes available for mass assignment
	 * 
	 * @var array
	 */
	protected $fillable = [ 'name' ];

	/**
	 * Defines the table name
	 * 
	 * @var string
	 */
	protected $hidden = ['pivot'];

	/**
	 * Relationship to Article model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function articles()
	{
		return $this->belongsToMany(Article::class, 'news_article_tag')->withTimestamps();
	}
	
	/**
	 * Create a new factory instance for the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Factories\Factory
	 */
	protected static function newFactory()
	{
		return TagFactory::new();
	}
}
