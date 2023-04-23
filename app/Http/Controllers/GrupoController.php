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
        $grupos = Grupo::withTags(Grupo::all());
        foreach ($grupos as $g)
            $g->tags = $g->tags->pluck('name');
        return $grupos;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->rules());

        // get the attributes to create a Grupo
        // the tags are not attributes
        $attributes = $request->validated();
        unset($attributes['tags']);

        // create the Grupo
        $grupo = Grupo::create($attributes);

        // set the Grupo tags
        $tags = Tag::findManyByName($request->tags);
        if ($tags->count() > 0)
            $grupo->setTags($tags);

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
       $request->validate($this->rules());

        // get the attributes to create a Grupo
        // the tags are not attributes
        $attributes = $request->validated();
        unset($attributes['tags']);

        // update attributes
        $grupo->update($attributes);

        // set the Grupo tags
        $tags = Tag::findManyByName($request->tags);
        if ($tags->count() > 0)
            $grupo->setTags($tags);
        else
            $grupo->delAllTags();

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
        $tags = Tag::all('name')->toArray();
        $tag_rule = Rule::in($tags);

        return [
            'titulo'    => 'required|string|min:2|max:200',
            'descricao' => 'required|string|max:5000',
            'tags'      => 'nullable|array|min:1|max:15',
            'tags.*'    => ['string', $tag_rule],
        ];
    }
}
