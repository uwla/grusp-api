<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GrupoController extends Controller
{
    use CrudController;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Grupo::class, 'grupo');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Grupo::withTagNames(Grupo::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate($this->rules());

        // the tags are not attributes
        unset($attributes['tags']);

        // create the Grupo
        $grupo = Grupo::create($attributes);

        // set the Grupo tags
        $tags = $request->tags;
        if (is_array($tags))
        {
            $tags = Tag::findByName($tags);
            $grupo->addTags($tags);
            $grupo->tags = $tags->pluck('name');
        }

        // upload file, if any
       if ($request->hasFile('img')) {
           $grupo->addMediaFromRequest('img')->toMediaCollection('cover_image');
       }

        // grant the user permission to access the Grupo
        $user = $request->user();
        $grupo->createCrudPermissions();
        $grupo->attachCrudPermissions($user);

        // return the Grupo
        return $grupo;
    }

    /**
     * Display the specified resource.
     */
    public function show(Grupo $grupo)
    {
        return $grupo;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grupo $grupo)
    {
        $attributes = $request->validate($this->rules());

        // the tags are not attributes
        unset($attributes['tags']);

        // update attributes
        $grupo->update($attributes);

        // set the Grupo tags
        $tags = $request->tags;
        if (is_array($request->tags)) {
            $tags = Tag::findByName($tags);
            $grupo->setTags($tags);
            $grupo->tags = $tags->pluck('name');
        } else {
            $grupo->delAllTags();
        }

        // return the updated Grupo
        return $grupo;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grupo $grupo)
    {
        $grupo->deleteThisModelPermissions();
        $grupo->delete();
        return $grupo;
    }

    /**
     * Get the validation rules.
     */
    public function rules()
    {
        $tags = Tag::taggedBy('taggable'); // only tags that are taggable
        $tag_rule = Rule::in($tags->pluck('name'));

        return [
            'titulo'    => 'required|string|min:2|max:200',
            'descricao' => 'required|string|max:5000',
            'img'       => 'nullable|mimes:jpg,png',
            'tags'      => 'nullable|array|min:1|max:15',
            'tags.*'    => $tag_rule,
        ];
    }
}
