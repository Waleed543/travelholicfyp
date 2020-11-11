<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookHotelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_hotel', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('hotel_id');
            $table->unsignedInteger('room_id');
            $table->integer('total_rooms');
            $table->integer('adults');
            $table->integer('children');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->string('status');
            $table->string('payment_type');
            $table->boolean('payment_status');
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('hotel_id')->on('tours')->references('id');
            $table->foreign('room_id')->on('tours')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_hotel');
    }
}
