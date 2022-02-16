<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlackHolesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('swc_blackholes', function (Blueprint $table) {
			$table->unsignedBigInteger('id')->unique();
			$table->string('name')->nullable()->default(null);
			$table->foreignId('system_id')->constrained('swc_systems')->onDelete('cascade');
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
		Schema::dropIfExists('swc_blackholes');
	}
}
