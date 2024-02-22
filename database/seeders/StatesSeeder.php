<?php

namespace Database\Seeders;

use App\Models\state;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $state = DB::table('states')->insert([
        //     'name' => "Punjab"
        // ]);
        $states = [
            ['name' => 'Nagland', 'country_id' => 3],
            ['name' => 'Toront', 'country_id' => 2],
            ['name' => 'Jammu', 'country_id' => 3],
            ['name' => 'New York', 'country_id' => 1],
            ['name' => 'Tokyo', 'country_id' => 4],

        ];
        state::insert($states);
    }
}
