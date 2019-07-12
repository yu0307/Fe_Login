<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'google_id')) {
                $table->dropColumn('google_id');
            }
            if (Schema::hasColumn('users', 'facebook_id')) {
                $table->dropColumn('facebook_id');
            }
            if (Schema::hasColumn('users', 'twitter_id')) {
                $table->dropColumn('twitter_id');
            }

            if (!Schema::hasColumn('users', 'provider_id')) {
                $table->string('provider_id')->nullable();
            }
            if (!Schema::hasColumn('users', 'provider_type')) {
                $table->char('provider_type', 225);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'provider_id')) {
                $table->dropColumn('provider_id');
            }
            if (Schema::hasColumn('users', 'provider_type')) {
                $table->dropColumn('provider_type');
            }
            if (!Schema::hasColumn('users', 'googel_id')) {
                $table->string('googel_id')->nullable();
            }
            if (!Schema::hasColumn('users', 'facebook_id')) {
                $table->string('facebook_id')->nullable();
            }
            if (!Schema::hasColumn('users', 'twitter_id')) {
                $table->string('twitter_id')->nullable();
            }
        });
        
    }
}
