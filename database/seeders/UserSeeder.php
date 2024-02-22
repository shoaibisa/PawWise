<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_user = User::create([
            'name' => 'Admin',
            'email' => 'admin@g.com',
            'password' => Hash::make('12345'), 
            'profile_img'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSE5D8WyZ9W5lSmzq2zs3aJBLZo-L0LHkNI8yO4BdLdIg&s'
        ]);
        $admin_user->assignRole('admin');
    }
}
