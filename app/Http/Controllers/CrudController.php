<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

Trait CrudController
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $modelClass = $this->model();
        $array = explode('\\', $modelClass);
        $slug = strtolower(end($array));
        $this->authorizeResource($modelClass, $slug);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->model()::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->rules());
        $model = $this->model()::create($request->validated());
        return $model;
    }

    /**
     * Display the specified resource.
     */
    public function show(Model $model)
    {
        return $model;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Model $model)
    {
        $request->validate($this->rules());
        $model->update($request->validated());
        return $model;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Model $model)
    {
        $model->delete();
        return $model;
    }
}
