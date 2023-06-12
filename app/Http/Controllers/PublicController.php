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
        return Grupo::withExtraData(Grupo::latest()->get());
    }

    /**
     * Show the Grupo
     **/
    public function grupo(Grupo $grupo)
    {
        return $grupo->attachExtraData();
    }

    /**
     * Get the public tags in a hierachical structure.
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
}
