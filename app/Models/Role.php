<?php

namespace App\Models;

use Uwla\Lacl\Models\Role as BaseRole;

class Role extends BaseRole
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
