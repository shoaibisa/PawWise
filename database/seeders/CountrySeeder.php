<?php

namespace Database\Seeders;

use App\Models\country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $countries = [
            ['name' => 'India'],
            ['name' => 'Japan'],
            ['name' => 'USA'],
            ['name' => 'UK'],
            ['name' => 'Paletine'],
            ['name' => 'South Korea'],
            // Add more countries as needed
        ];

        // Insert the data into the countries table
        country::insert($countries);
    }
}
