<?php

use Illuminate\Database\Seeder;
use App\Model\blog_category;
class Category extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        blog_category::create(['name' => 'Food']);
        blog_category::create(['name' => 'Hotel']);
        blog_category::create(['name' => 'Vehicle']);
        blog_category::create(['name' => 'Tour']);
        blog_category::create(['name' => 'Restaurant']);
    }
}
