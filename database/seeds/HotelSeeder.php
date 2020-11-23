<?php

use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Facility::create([
            'name' => 'AC',
            'slug' => 'AC'
        ]);
        \App\Facility::create([
            'name' => 'Heater',
            'slug' => 'Heater'
        ]);
        \App\Facility::create([
            'name' => 'Attached Bathroom',
            'slug' => 'Attached_Bathroom'
        ]);

        \App\Hotel::create([
            'user_id' => 1,
            'slug' => 'Star-Hotel',
            'name' => 'Star Hotel',
            'description' => 'dasfasfasdfasdfasdfasdfasdfasdfasdf',
            'total_rooms' => 8,
            'available_rooms' => 8,
            'city' => 2,
            'thumbnail' => 'none',
            'status' => 'Active'
        ]);

        \App\Room::create([
            'hotel_id' => 1,
            'slug' => 'Queen-Room',
            'name' => 'Queen Room',
            'description' => 'dasfasfasdfasdfasdfasdfasdfasdfasdf',
            'capacity' => 2,
            'total' => 8,
            'available' => 8,
            'beds' => 1,
            'price' => 9800,
            'thumbnail' => 'none',
            'status' => 'Active'
        ]);
    }
}
