<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $role_admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $role_bank = Role::firstOrCreate(['name' => 'bank', 'guard_name' => 'web']);
        $role_user = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        
 
        $p1 = Permission::firstOrCreate(['name' => 'edit users', 'guard_name' => 'web']);
        $p2 = Permission::firstOrCreate(['name' => 'edit transactions', 'guard_name' => 'web']);
        $p3 = Permission::firstOrCreate(['name' => 'add transactions', 'guard_name' => 'web']);

        // $role_admin->permissions()->attach([$p1->id, $p2->id]);
        // $role_bank->permissions()->attach([$p3]);
        // $role_user->permissions()->attach([$p3->id]);
        $role_bank->syncPermissions([$p2 ]);  // removing all permisssion and adding new one
        // $role_admin->revokePermissionTo($p2);
    }
}
