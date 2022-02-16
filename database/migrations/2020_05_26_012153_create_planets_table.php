<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanetsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('swc_planets', function (Blueprint $table) {
			$table->unsignedBigInteger('id')->unique();
			$table->string('name')->nullable()->default(null);
			$table->unsignedInteger('x_coordinate');
			$table->unsignedInteger('y_coordinate');
			$table->foreignId('system_id')->constrained('swc_systems')->onDelete('cascade');
			$table->unsignedBigInteger('population');
			$table->decimal('civilisation')->nullable()->default(null);
			$table->decimal('morale')->nullable()->default(null);
			$table->decimal('crime')->nullable()->default(null);
			$table->decimal('tax')->default(0);
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
		Schema::dropIfExists('swc_planets');
	}
}
