<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags_tour', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('tour_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();
            $table->foreign('tour_id')->references('id')->on('tours');
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
        Schema::dropIfExists('tags_tour');
    }
}
