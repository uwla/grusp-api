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
        $users = User::factory(50)->create();
        $user_role = Role::where('name', 'user')->first();
        User::addRoleToMany($user_role, $users);

        $adm = User::factory()->createOne();
        $adm->update(['email' => 'adm@usp.br']);
        $adm->addRole('admin');

        User::createCrudPermissions();  // create permissions for CRUD actions
    }
}
