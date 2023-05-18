<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Uwla\Lacl\Traits\Permissionable;
use Uwla\Ltags\Traits\Taggable;

class Grupo extends Model implements HasMedia
{
    use HasFactory, Taggable, Permissionable, InteractsWithMedia;

    /**
     * The attributes that are not mass assignable.
     * Other attributes will be regarded as mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * The cover image of the Grupo.
     */
    public function cover_image()
    {
       return $this->hasOne(Media::class, 'model_id')->where('collection_name', 'cover_image');
    }

    /**
     * The content images of the Grupo
     */
    public function content_images()
    {
       return $this->hasMany(Media::class, 'model_id')->where('collection_name', 'content_images');
    }
}
