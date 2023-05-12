<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Uwla\Lacl\Traits\Permissionable;
use Uwla\Ltags\Traits\Taggable;

class Grupo extends Model
{
    use HasFactory, Taggable, Permissionable;

    /**
     * The attributes that are not mass assignable.
     * Other attributes will be regarded as mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
