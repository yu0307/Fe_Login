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
                $table->char('email',225)->nullable();
                $table->string('password')->nullable();
                $table->boolean('remember_token')->default(false);
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('last_login')->nullable();
                $table->string('googel_id')->nullable();
                $table->string('facebook_id')->nullable();
                $table->string('twitter_id')->nullable();
            });
        }else{
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'name')) { $table->string('name')->nullable(); }
                if (!Schema::hasColumn('users', 'email')) { $table->char('email',225)->nullable(); }
                if (!Schema::hasColumn('users', 'password')) { $table->string('password')->nullable(); }
                if (!Schema::hasColumn('users', 'remember_token')) { $table->boolean('remember_token')->default(false); }
                if (!Schema::hasColumn('users', 'created_at')) { $table->dateTime('created_at')->nullable(); }
                if (!Schema::hasColumn('users', 'updated_at')) { $table->dateTime('updated_at')->nullable(); }
                if (!Schema::hasColumn('users', 'last_login')) { $table->dateTime('last_login')->nullable(); }
                if (!Schema::hasColumn('users', 'googel_id')) { $table->string('googel_id')->nullable(); }
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
