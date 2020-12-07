<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('slug',100)->unique();
            $table->string('name', 100);
            $table->mediumText('description');
            $table->string('year', 20);
            $table->string('make', 100);
            $table->string('model', 100);
            $table->string('color', 100);
            $table->string('condition', 100);
            $table->integer('mileage');
            $table->string('vinumber', 100);
            $table->integer('price');
            $table->unsignedInteger('city');
            $table->string('thumbnail');
            $table->string('status',100);
            $table->softDeletes();
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
        Schema::dropIfExists('vehicles');
    }
}
