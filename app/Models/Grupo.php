<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Uwla\Ltags\Traits\Taggable as HasTags;
use Uwla\Ltags\Contracts\Taggable as TaggableContract;

class Grupo extends Model implements TaggableContract
{
    use HasFactory, HasTags;
}
