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
        Schema::create('systems', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->string('name')->nullable()->default(null);;
            $table->integer('x_coordinate');
            $table->integer('y_coordinate');
            $table->unsignedBigInteger('sector_id')->nullable()->default(null);;
            $table->timestamps();

            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('systems');
    }
}
