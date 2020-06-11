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
        Schema::create('planets', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique;
            $table->string('name');
            $table->unsignedInteger('x_coordinate');
            $table->unsignedInteger('y_coordinate');
            $table->unsignedBigInteger('system_id');
            $table->timestamps();

            $table->primary('id');
            $table->foreign('system_id')->references('id')->on('systems');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planets');
    }
}
