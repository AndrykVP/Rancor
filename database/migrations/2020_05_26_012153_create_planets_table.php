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
            $table->unsignedBigInteger('system_id')->nullable()->default(null);
            $table->float('civilisation')->nullable()->default(null);
            $table->float('morale')->nullable()->default(null);
            $table->float('crime')->nullable()->default(null);
            $table->integer('tax')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('system_id')->references('id')->on('swc_systems')->onDelete('set null');
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
