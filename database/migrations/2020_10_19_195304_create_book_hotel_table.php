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
            $table->string('number',100)->unique();
            $table->integer('adults');
            $table->integer('children');
            $table->integer('total_rooms');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->string('status');
            $table->string('payment_type');
            $table->string('payment_status');
            $table->string('trxid')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('hotel_id')->on('hotels')->references('id');
            $table->foreign('room_id')->on('rooms')->references('id');
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
