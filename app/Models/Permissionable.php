<?php

namespace App\Models;

use App\Models\Permission;
use App\Models\Role;
use Uwla\Lacl\Traits\Permissionable as BasePermissionable;

Trait Permissionable
{
    use BasePermissionable;

    public static function Role()
    {
        return Role::class;
    }

    public static function Permission()
    {
        return Permission::class;
    }
}
