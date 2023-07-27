<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory, Permissionable;

    /**
     * Attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Whether to use created_at/updated_a timestamp fields.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Attributes that hidden in requests.
     *
     * @var array
     */
    protected $hidden = ['user_id'];
}
