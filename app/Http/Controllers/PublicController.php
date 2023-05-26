<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Tag;

class PublicController extends Controller
{
    /**
     * Get the grupos (which are all public) along with their tags.
     */
    public function grupos()
    {
        return Grupo::withTagNames(Grupo::all());
    }

    /**
     *
     **/
    public function grupo(Grupo $grupo)
    {
        $grupo->tags = $grupo->getTagNames();

        // TODO: refactor this silly code
        $cover_image = $grupo->cover_image;
        $cover_image_url = $cover_image ? $cover_image->getFullUrl() : null;
        $grupo->img = $cover_image_url;
        unset($grupo->cover_image);

        $content_images = $grupo->content_images;
        $content_images_url = $content_images ?
            $content_images->map(fn($img) => $img->getFullUrl()) : array();
        $grupo->images = $content_images_url;
        unset($grupo->content_images);

        return $grupo;
    }

    /**
     * Get the public tags in a hierachical structure.
     */
    public function tags()
    {
        // take all tags which are tags and group them by their parent tag
        $tags = Tag::byTags(Tag::taggedBy('taggable'));

        // unset the taggable tag, since this is an internal tag
        unset($tags['taggable']);

        // we want just the name of the tags, not their ids or other information
        foreach ($tags as $key => $value)
            $tags[$key] = collect($value)->pluck('name');

        return $tags;
    }
}
