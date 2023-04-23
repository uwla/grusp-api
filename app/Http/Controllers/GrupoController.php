<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;

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
        $grupo = Grupo::create($request->validated());
        $user = $request->user();
        $grupo->createCrudPermissions();
        $grupo->attachCrudPermissions($user);
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
        $grupo->update($request->validated());
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
        return [
            'titulo'    => 'required|string|min:2|max:200',
            'descricao' => 'required|string|max:5000',
        ];
    }
}
