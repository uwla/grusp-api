<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Tag;
use App\Models\Role;
use App\Models\Grupo;
use App\Models\Permission;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        // any user can create a grupo or vote on a grupo
        $user->addPermission(Vote::getCreatePermission());
        $user->addPermission(Grupo::getCreatePermission());
        $user->addPermission(Comment::getCreatePermission());

        // managers have access to all grupos and tags
        $manager->addPermissions(Tag::getCrudPermissions());
        $manager->addPermissions(Grupo::getCrudPermissions());

        // admins have all permissions
        $admin->addPermissions(Permission::all());
    }
}
