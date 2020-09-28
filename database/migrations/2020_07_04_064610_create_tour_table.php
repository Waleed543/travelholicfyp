<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('slug',60)->unique();
            $table->string('name', 50);
            $table->mediumText('description');
            $table->unsignedInteger('departure_city');
            $table->unsignedInteger('destination_city');
            $table->timestamp('departure_date')->nullable();
            $table->timestamp('returning_date')->nullable();
            $table->integer('nights_to_stay');
            $table->integer('total_seats');
            $table->integer('remaining_seats');
            $table->integer('price');
            $table->string('thumbnail');
            $table->string('status',50);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('tours');
    }
}
