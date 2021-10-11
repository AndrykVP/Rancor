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
            $table->foreignId('type_id')->nullable()->default(null)->constrained('scanner_territory_types')->onDelete('set null');
            $table->foreignId('quadrant_id')->constrained('scanner_quadrants')->onDelete('cascade');
            $table->integer('x_coordinate');
            $table->integer('y_coordinate');
            $table->boolean('subscription');
            $table->foreignId('patrolled_by')->nullable()->default(null)->constrained('users')->onDelete('set null');
            $table->timestamp('last_patrol')->nullable()->default(null);
            $table->timestamps();
            
            $table->index(['x_coordinate', 'y_coordinate']);
            $table->index('subscription');
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
