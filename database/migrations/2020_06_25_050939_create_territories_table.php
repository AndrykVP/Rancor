<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerritoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scanner_territories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->default(null);
            $table->unsignedBigInteger('type_id')->nullable()->default(null);
            $table->unsignedBigInteger('quadrant_id')->nullable()->default(null);
            $table->integer('x_coordinate');
            $table->integer('y_coordinate');
            $table->unsignedBigInteger('patrolled_by')->nullable()->default(null);
            $table->timestamp('last_patrol')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('quadrant_id')->references('id')->on('scanner_quadrants')->onDelete('set null');
            $table->foreign('type_id')->references('id')->on('scanner_territory_types')->onDelete('set null');
            $table->foreign('patrolled_by')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('scanner_territories');
    }
}
