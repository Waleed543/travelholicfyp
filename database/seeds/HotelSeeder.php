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
    }
}
