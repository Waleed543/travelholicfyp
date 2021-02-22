<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookVehicle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_vehicle', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('vehicle_id');
            $table->string('number',100)->unique();
            $table->integer('days');
            $table->integer('adults');
            $table->integer('children');
            $table->unsignedInteger('departure_city');
            $table->unsignedInteger('destination_city');
            $table->timestamp('departure_date')->nullable();
            $table->timestamp('returning_date')->nullable();
            $table->string('phone');
            $table->string('status');
            $table->string('payment_type');
            $table->string('payment_status');
            $table->string('trxid')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('vehicle_id')->on('vehicles')->references('id');
            $table->foreign('departure_city')->references('id')->on('city');
            $table->foreign('destination_city')->references('id')->on('city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_vehicle');
    }
}
