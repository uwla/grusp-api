<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Uwla\Ltags\Traits\Taggable as HasTags;
use Uwla\Ltags\Contracts\Taggable as TaggableContract;

class Grupo extends Model implements TaggableContract
{
    use HasFactory, HasTags;

    public static function all($columns = ['*'])
    {
        $all = parent::all($columns);
        $tagged = self::withTags($all);
        foreach ($tagged as $g)
            $g->tags = $g->tags->pluck('name');
        return $tagged;
    }
}
