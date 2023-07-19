<?php

namespace App\Models;

use Uwla\Lacl\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    public static function Role()
    {
        return Role::class;
    }

    public static function Permission()
    {
        return Permission::class;
    }
}
