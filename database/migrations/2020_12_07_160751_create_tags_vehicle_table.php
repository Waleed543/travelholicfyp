<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags_vehicle', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('vehicle_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags_vehicle');
    }
}
