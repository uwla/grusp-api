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
        return Grupo::withExtraData(Grupo::inRandomOrder()->get());
    }

    /**
     * Show the Grupo
     **/
    public function grupo(Grupo $grupo)
    {
        $grupo = $grupo->attachExtraData();
        $grupo->images = $grupo->images->pluck('url');
        return $grupo;
    }

    /**
     * Get the public tags in a hierarchical structure.
     */
    public function tags()
    {
        // take all tags which are Grupo tags
        $tags = Tag::byTags(Tag::where('namespace', 'grupo')->get());

        // we want just the name of the tags, not their ids or other information
        foreach ($tags as $key => $value)
            $tags[$key] = collect($value)->pluck('name');

        return $tags;
    }

    /**
     * Get the tag categories
     */
    public function categories()
    {
        $tags = Tag::where('namespace', 'tag')->get();
        return $tags->pluck('name');
    }
}
