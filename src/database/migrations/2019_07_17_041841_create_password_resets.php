<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('password_resets')) {
            Schema::create('password_resets', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('email')->index();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }else{
            Schema::table('password_resets', function (Blueprint $table) {
                if (!Schema::hasColumn('password_resets', 'id')) { $table->bigIncrements('id')->first(); }
                if (!Schema::hasColumn('password_resets', 'email')) { $table->string('email')->index(); }
                if (!Schema::hasColumn('password_resets', 'token')) { $table->string('password')->nullable(); }
                if (!Schema::hasColumn('password_resets', 'created_at')) { $table->dateTime('created_at')->nullable(); }
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
        Schema::dropIfExists('password_resets');
    }
}
