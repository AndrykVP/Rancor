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
            $table->string('old_type')->nullable();
            $table->string('old_name')->nullable();
            $table->string('old_owner')->nullable();
            $table->tinyInteger('old_alliance')->nullable();
            $table->foreignId('old_territory_id')->nullable()->default(null)->constrained('scanner_territories')->onDelete('cascade');
            $table->foreignId('updated_by')->constrained()->onDelete('cascade');
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
