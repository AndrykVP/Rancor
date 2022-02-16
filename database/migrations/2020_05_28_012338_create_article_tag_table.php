<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleTagTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news_article_tag', function (Blueprint $table) {
			$table->foreignId('article_id')->contrained('news_articles')->onDelete('cascade');;
			$table->foreignId('tag_id')->constrained('news_tags')->onDelete('cascade');;
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('news_article_tag');
	}
}
