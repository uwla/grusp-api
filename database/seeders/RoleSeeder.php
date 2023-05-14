<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Grupo;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::createCrudPermissions();

        // some basic roles
        $user = Role::create([
            'name' => 'user',
            'description' => 'Regular authenticated user',
        ]);
        $manager = Role::create([
            'name' => 'manager',
            'description' => 'Manage all grupos.',
        ]);
        $admin = Role::create([
            'name' => 'admin',
            'description' => 'Administrator',
        ]);

        // any user can create a grupo
        $user->addPermission(Grupo::getCreatePermission());

        // managers have access to all grupos
        $manager->addPermissions(Grupo::getCrudPermissions());

        // admins have all permissions
        $admin->addPermissions(Permission::all());
    }
}
