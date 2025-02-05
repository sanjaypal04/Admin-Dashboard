<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create Roles
        $admin = Role::create(['name' => 'Admin']);
        $user = Role::create(['name' => 'User']);

        // Create Permissions
        $viewUsers = Permission::create(['name' => 'view users']);
        $editUsers = Permission::create(['name' => 'edit users']);

        // Assign Permissions to Roles
        $admin->givePermissionTo([$viewUsers, $editUsers]);
        $user->givePermissionTo($viewUsers);

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole('Admin');
        
        // Create a regular User and assign the User role
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
        ]);
        $user->assignRole('User');
    }
}
