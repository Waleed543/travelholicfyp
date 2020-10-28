<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tour;
use Faker\Generator as Faker;

$factory->define(Tour::class, function (Faker $faker) {
    return [
        'user_id' => 2,
        'name' => $faker->title,
        'slug' =>  $this->faker->unique()->safeEmail,
        'description' => $faker->paragraph,
        'departure_city' => 11,
        'destination_city' => 14,
        'departure_date' => date("Y/m/d"),
        'returning_date' => date("Y/m/d"),
        'nights_to_stay' => 1,
        'total_seats' => $seats = rand(10,100),
        'remaining_seats' => $seats,
        'price' => rand(100,10000),
        'thumbnail' => 'a',
        'status' => 'Active',
    ];
});
