<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('slug',100)->unique();
            $table->string('name', 100);
            $table->mediumText('description');
            $table->integer('total_rooms');
            $table->integer('available_rooms');
            $table->unsignedInteger('city');
            $table->string('thumbnail');
            $table->string('status',100);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('city')->references('id')->on('city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotels');
    }
}
