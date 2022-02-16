<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forum_boards', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->text('description')->nullable()->default(null);
			$table->string('slug')->unique();
			$table->foreignId('category_id')->constrained('forum_categories')->onDelete('cascade');
			$table->foreignId('parent_id')->nullable()->default(null)->constrained('forum_categories')->onDelete('cascade');
			$table->unsignedBigInteger('lineup');
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
		Schema::dropIfExists('forum_boards');
	}
}
