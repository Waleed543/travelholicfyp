<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookTourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_tour', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('tour_id');
            $table->integer('seats');
            $table->integer('adults');
            $table->integer('children');
            $table->string('phone');
            $table->string('status');
            $table->string('payment_type');
            $table->boolean('payment_status');
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('tour_id')->on('tours')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_tour');
    }
}
