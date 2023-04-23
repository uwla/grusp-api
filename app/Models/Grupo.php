<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Uwla\Ltags\Traits\Taggable as HasTags;
use Uwla\Ltags\Contracts\Taggable as TaggableContract;
use Uwla\Lacl\Traits\Permissionable;
use Uwla\Lacl\Contracts\Permissionable as PermissionableContract;

class Grupo extends Model implements TaggableContract, PermissionableContract
{
    use HasFactory, HasTags, Permissionable;
}
