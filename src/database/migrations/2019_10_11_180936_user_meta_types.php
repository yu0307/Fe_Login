<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserMetaTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User_MetaTypes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('meta_name', 225);
            $table->string('meta_type', 225);
            $table->text('meta_defaults')->nullable();
            $table->timestamps();

            $table->unique(['meta_name', 'meta_type']);
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('User_MetaTypes');
    }
}
