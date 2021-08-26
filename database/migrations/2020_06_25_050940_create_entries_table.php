<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scanner_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entity_id');
            $table->string('type')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('owner')->nullable()->default(null);
            $table->json('position')->nullable()->default(null);
            $table->foreignId('updated_by')->nullable()->default(null)->constrained('users')->onDelete('set null');
            $table->timestamp('last_seen')->nullable()->default(null);
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
        Schema::dropIfExists('scanner_entries');
    }
}
