<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Grupo;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $uids = User::all()->pluck('id');
        $gids = Grupo::all()->pluck('id');
        $toCreate = [];
        $faker = \Faker\Factory::create();
        foreach ($gids as $gid)
        {
            $n = random_int(1, 6);
            $c_uids = $uids->random($n);
            foreach ($c_uids as $c_uid)
            {
                $date = $faker->dateTime();
                $comment = [
                    'comment' => $faker->sentence(10),
                    'user_id' => $c_uid,
                    'grupo_id' => $gid,
                    'updated_at' => $date,
                    'created_at' => $date,
                ];
                $toCreate[] = $comment;
            }
        };
        Comment::insert($toCreate);
    }
}
