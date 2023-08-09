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
        // create many users in development only
        if (app()->isLocal())
        {
            $users = User::factory(50)->create();
            $user_role = Role::where('name', 'user')->first();
            User::addRoleToMany($user_role, $users);
        }

        $adm_email = env('ADM_EMAIL', 'null');
        $adm_pass = env('ADM_PASS', 'null');
        if ($adm_email !== null && $adm_pass !== null)
        {
            $adm = User::create([
                'name'     => 'admin',
                'email'    => $adm_email,
                'password' => $adm_pass,
                'email_verified_at' => now(),
            ]);
            $adm->addRole('admin');
        }
    }
}
