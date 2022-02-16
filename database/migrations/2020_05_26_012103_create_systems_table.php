<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('swc_systems', function (Blueprint $table) {
			$table->unsignedBigInteger('id')->unique();
			$table->string('name')->nullable()->default(null);;
			$table->integer('x_coordinate');
			$table->integer('y_coordinate');
			$table->foreignId('sector_id')->constrained('swc_sectors')->onDelete('cascade');
			$table->timestamps();

			$table->index(['x_coordinate', 'y_coordinate']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('swc_systems');
	}
}
