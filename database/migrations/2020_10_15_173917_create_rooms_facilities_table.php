<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms_facilities', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('room_id');
            $table->unsignedInteger('facility_id');
            $table->timestamps();
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('facility_id')->references('id')->on('facilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms_facilities');
    }
}
