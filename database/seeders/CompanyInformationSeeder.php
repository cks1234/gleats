<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('company_information')->insert([
            'license' => '70387',
            'name' => 'G L ELECTRONIC & TECH SOLUTIONS PTY LTD',
            'post_office_box' => '315',
            'address' => 'NATHAN QLD 4111',
            'phone' => '07 3193 9791',
            'mobile' => '0429 777 668',
            'email' => 'admin@gleats.com',
        ]);
    }
}
