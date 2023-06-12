<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Uwla\Lacl\Traits\Permissionable;
use Uwla\Ltags\Models\Tag as BaseTag;

class Tag extends BaseTag
{
    use HasFactory, Permissionable;

    public function getTagNamespace()
    {
        return 'tag';
    }
}
