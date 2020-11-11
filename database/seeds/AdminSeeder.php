<?php

use App\User;
use App\Role;
use App\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('11223344'),
        ]);
        Profile::create([
            'user_id' => 1,
        ]);

        Role::create([
            'name' => 'Admin'
        ]);

        DB::table('role_user')->insert(
            ['user_id' => 1, 'role_id' => 1]
        );
    }
}
