<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRanksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('structure_ranks', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->text('description')->nullable()->default(null);
			$table->string('color')->nullable()->default(null);
			$table->foreignId('department_id')->constrained('structure_departments')->onDelete('cascade');
			$table->unsignedTinyInteger('level')->default(1);
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
		Schema::dropIfExists('structure_ranks');
	}
}
