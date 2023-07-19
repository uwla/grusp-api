<?php

namespace Database\Seeders;

use App\Models\Grupo;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Grupo::createCrudPermissions();
        Permission::createViewPermission();
        Permission::createViewAnyPermission();
        Role::createCrudPermissions();
        Tag::createCrudPermissions();
        User::createCrudPermissions();
    }
}
