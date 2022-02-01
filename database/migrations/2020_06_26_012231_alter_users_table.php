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
            $table->string('first_name')->after('name');
            $table->string('last_name')->after('first_name');
            $table->foreignId('homeplanet')->nullable()->default(null)->after('last_name')->constrained('swc_planets')->onDelete('set null');
            $table->string('avatar')->nullable()->default(null)->after('homeplanet');
            $table->string('signature')->nullable()->default(null)->after('avatar');
            $table->string('nickname')->nullable()->default(null)->after('email');
            $table->text('quote')->nullable()->default(null)->after('nickname');
            $table->foreignId('rank_id')->nullable()->default(null)->after('quote')->constrained('structure_ranks')->onDelete('set null');
            $table->boolean('show_email')->default(1)->after('rank_id');
            $table->boolean('is_admin')->default(0)->after('show_email');
            $table->boolean('is_banned')->default(0)->after('is_admin');
            $table->unsignedBigInteger('online_time')->default(0)->after('is_banned')->comment('In Minutes');
            $table->timestamp('last_seen_at')->nullable()->default(null);
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
            $table->dropColumn([
                'first_name',
                'last_name',
                'homeplanet',
                'avatar',
                'signature',
                'nickname',
                'quote',
                'rank_id',
                'show_email',
                'is_admin',
                'is_banned',
                'online_time',
                'last_seen_at'
            ]);
        });
    }
}
