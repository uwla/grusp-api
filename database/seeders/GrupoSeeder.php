<?php

namespace Database\Seeders;

use App\Models\Grupo;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupos = Grupo::factory(100)->create();
        $tags = Tag::all();

        // add between 1 and 5 random tags to each grupo
        $grupos->each(fn($g) => $g->addTags($tags->random(random_int(1, 5))));
    }
}
