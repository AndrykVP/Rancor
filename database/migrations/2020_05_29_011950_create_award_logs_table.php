<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardLogsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('changelog_awards', function (Blueprint $table) {
			$table->id();
			$table->foreignId('award_id')->constrained('structure_awards')->onDelete('cascade');
			$table->foreignId('user_id')->constrained()->onDelete('cascade');
			$table->integer('action');
			$table->foreignId('updated_by')->nullable()->default(null)->constrained('users')->onDelete('set null');
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
		Schema::dropIfExists('changelog_awards');
	}
}
