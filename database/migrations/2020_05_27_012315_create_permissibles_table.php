<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissiblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rancor_permissibles', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->morphs('permissible');
            $table->timestamps();

            $table->foreign('permission_id')->references('id')->on('rancor_permissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rancor_permissibles');
    }
}
