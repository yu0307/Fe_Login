<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            // create the tblCategory table
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->nullable();
                $table->string('email')->unique();
                $table->string('password')->nullable();
                $table->string('remember_token')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('last_login')->nullable();
                $table->string('google_id')->nullable();
                $table->string('facebook_id')->nullable();
                $table->string('twitter_id')->nullable();
            });
        }else{
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'name')) { $table->string('name')->nullable(); }
                if (!Schema::hasColumn('users', 'email')) { $table->string('email')->unique(); }
                if (!Schema::hasColumn('users', 'password')) { $table->string('password')->nullable(); }
                if (!Schema::hasColumn('users', 'remember_token')) { $table->string('remember_token')->nullable(); }
                if (!Schema::hasColumn('users', 'created_at')) { $table->dateTime('created_at')->nullable(); }
                if (!Schema::hasColumn('users', 'updated_at')) { $table->dateTime('updated_at')->nullable(); }
                if (!Schema::hasColumn('users', 'last_login')) { $table->dateTime('last_login')->nullable(); }
                if (!Schema::hasColumn('users', 'google_id')) { $table->string('google_id')->nullable(); }
                if (!Schema::hasColumn('users', 'facebook_id')) { $table->string('facebook_id')->nullable(); }
                if (!Schema::hasColumn('users', 'twitter_id')) { $table->string('twitter_id')->nullable(); }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
