<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->default(null)->after('name');
            $table->mediumtext('nickname')->nullable()->default(null)->after('email');
            $table->unsignedBigInteger('rank_id')->nullable()->default(null)->after('nickname');
            $table->boolean('is_admin')->default(0)->after('rank_id');
            $table->timestamp('last_login')->nullable()->default(null);

            $table->foreign('rank_id')->references('id')->on('ranks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('nickname');
            $table->dropColumn('rank_id');
            $table->dropColumn('is_admin');
            $table->dropColumn('last_login');
        });
    }
}
