<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntryLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('changelog_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entry_id')->constrained('scanner_entries')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('old_type')->nullable();
            $table->string('new_type')->nullable();
            $table->string('old_name')->nullable();
            $table->string('new_name')->nullable();
            $table->string('old_owner')->nullable();
            $table->string('new_owner')->nullable();
            $table->foreignId('new_territory_id')->nullable()->default(null)->constrained('scanner_territories')->onDelete('cascade');
            $table->foreignId('old_territory_id')->nullable()->default(null)->constrained('scanner_territories')->onDelete('cascade');
            $table->tinyInteger('new_alliance')->nullable();
            $table->tinyInteger('old_alliance')->nullable();
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
        Schema::dropIfExists('changelog_entries');
    }
}
