<?php

namespace App\Models;

use Uwla\Lacl\Models\Role as BaseRole;

class Role extends BaseRole
{
    use Permissionable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ 'name', 'description' ];
}
