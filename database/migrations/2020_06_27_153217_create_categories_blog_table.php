<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_for_blog', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('name',100)->unique();
            $table->unsignedInteger('parent_id')->nullable();
            $table->timestamps();
        });
        Schema::table('categories_for_blog', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('categories_for_blog');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_for_blog');
    }
}
