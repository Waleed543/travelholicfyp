<?php

use App\User;
use App\Role;
use App\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'bilal',
            'username' => 'bilal',
            'email' => 'bilal@gmail.com',
            'password' => Hash::make('11223344'),
        ]);
        Profile::create([
            'user_id' => 2,
        ]);

        Role::create([
            'name' => 'Standard'
        ]);

        DB::table('role_user')->insert(
            ['user_id' => 2, 'role_id' => 2]
        );
    }
}
