<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Blog;
use Faker\Generator as Faker;

$factory->define(Blog::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'title' => $faker->name,
        'slug'=> $this->faker->unique()->safeEmail,
        'thumbnail' => 'none',
        'body' => $faker->paragraph,
        'status' => 'Active'
    ];
});
