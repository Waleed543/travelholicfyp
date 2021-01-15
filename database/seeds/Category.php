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
        blog_category::create(['name' => 'Food', 'slug' => 'food']);
        blog_category::create(['name' => 'Hotel', 'slug' => 'hotel']);
        blog_category::create(['name' => 'Vehicle', 'slug' => 'vehicle']);
        blog_category::create(['name' => 'Tour', 'slug' => 'tour']);
        blog_category::create(['name' => 'Restaurant', 'slug' => 'restaurant']);
    }
}
