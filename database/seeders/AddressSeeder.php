<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addresses = [
            ["user_id" => 2, "city_id" => 4, "state_id" => 10, "country_id" => 1],
            ["user_id" => 3, "city_id" => 1, "state_id" => 4, "country_id" => 3],
        ];
        Address::insert($addresses);
    }
}
