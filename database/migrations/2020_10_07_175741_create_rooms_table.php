<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('hotel_id');
            $table->string('slug',100)->unique();
            $table->string('name', 100);
            $table->mediumText('description');
            $table->integer('total');
            $table->integer('beds');
            $table->integer('available');
            $table->integer('price');
            $table->string('thumbnail');
            $table->timestamps();
            $table->foreign('hotel_id')->references('id')->on('hotels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
