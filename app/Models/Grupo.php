<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
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
     * Get the namespace of the tags associated with this model.
     *
     * @return string
     */
    public function getTagNamespace()
    {
        return 'grupo';
    }

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

    /**
     * Attach the urls of the media associated with this model.
     *
     * @return $this
     **/
    public function attachMediaUrl()
    {
        // get the urls of the media
        $cover_image = $this->cover_image;
        $cover_image = $cover_image ? $cover_image->getFullUrl() : null;

        $mapImg = fn($img) => ['id' => $img->id, 'url' => $img->getFullUrl()];
        $content_images = $this->content_images;
        $content_images = $content_images ? $content_images->map($mapImg) : array();

        // delete cumbersome attributes (we want just the url)
        unset($this->cover_image);
        unset($this->content_images);

        // attach the url
        $this->img = $cover_image;
        $this->images = $content_images ?? [];

        return $this;
    }

    /**
     * Attach the tags associated with this model
     *
     * @return $this
     **/
    public function attachTags()
    {
        $this->tags = $this->getTagNames();
        return $this;
    }

    /**
     * Attach extra data to this model (tags and media)
     *
     * @return $this
     **/
    public function attachExtraData()
    {
        return $this->attachTags()->attachMediaUrl();
    }

    /**
     * Get the given grupos with extra data (tags and media)
     *
     * @param  \Illuminate\Database\Eloquent\Collection
     * @return \Illuminate\Database\Eloquent\Collection
     **/
    public static function withExtraData($grupos)
    {
        return Grupo::withTagNames($grupos)->map(fn($g) => $g->attachMediaUrl());
    }
}
