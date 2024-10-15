<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gleats.com',
            'password' => Hash::make('password#'),
            'phone' => '07 3193 9791',
            'mobile' => '0429 777 668',
            'address' => 'NATHAN QLD 4111',
            'role' => 'admin',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Adam',
            'email' => 'adam@gleats.com',
            'password' => Hash::make('password#'),
            'phone' => '07 3193 9791',
            'mobile' => '0429 777 668',
            'address' => 'NATHAN QLD 4111',
            'role' => 'manager',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'John',
            'email' => 'john@gleats.com',
            'password' => Hash::make('password#'),
            'phone' => '07 3193 9791',
            'mobile' => '0429 777 668',
            'address' => 'NATHAN QLD 4111',
            'role' => 'contractor',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Sam',
            'email' => 'sam@gleats.com',
            'password' => Hash::make('password#'),
            'phone' => '07 3193 9791',
            'mobile' => '0429 777 668',
            'address' => 'NATHAN QLD 4111',
            'role' => 'tradesperson',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Malcom',
            'email' => 'malcom@gleats.com',
            'password' => Hash::make('password#'),
            'phone' => '07 3193 9791',
            'mobile' => '0429 777 668',
            'address' => 'NATHAN QLD 4111',
            'role' => 'labourer',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
