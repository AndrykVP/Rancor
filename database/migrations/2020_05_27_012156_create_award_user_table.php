<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardUserTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('structure_award_user', function (Blueprint $table) {
			$table->foreignId('award_id')->constrained('structure_awards')->onDelete('cascade');
			$table->foreignId('user_id')->constrained()->onDelete('cascade');;
			$table->unsignedInteger('level')->default(1);
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
		Schema::dropIfExists('structure_award_user');
	}
}
