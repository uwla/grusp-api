<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // development only
        $users = User::factory(200)->create();
        $user_role = Role::where('name', 'user')->first();
        User::addRoleToMany($user_role, $users);

        User::createCrudPermissions();  // create permissions for CRUD actions
    }
}
