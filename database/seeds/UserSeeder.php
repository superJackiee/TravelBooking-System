<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Admin Admin',
            'email' => 'admin@black.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('account')->insert([
            'id' => 1,
            'user_id' =>1 ,
            'account_type'=> 3,
            'status' => 1,
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
