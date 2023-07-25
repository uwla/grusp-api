<?php

namespace Database\Seeders;

use App\Models\Grupo;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $uids = User::all()->pluck('id');
        $gids = Grupo::all()->pluck('id');
        $toCreate = [];
        foreach ($gids as $gid)
        {
            $n = random_int(2, 10);
            $v_uids = $uids->random($n);
            foreach ($v_uids as $v_uid)
            {
                $comment = [
                    'vote' => random_int(0,1),
                    'user_id' => $v_uid,
                    'grupo_id' => $gid,
                ];
                $toCreate[] = $comment;
            }
        };
        Vote::insert($toCreate);
    }
}
