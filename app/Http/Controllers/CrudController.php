<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

Trait CrudController
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // this handles authorization:

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
    public function show($model)
    {
        return $this->model()::find($model);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $model)
    {
        $request->validate($this->rules());
        $model = $this->model()::find($model);
        $model->update($request->validated());
        return $model;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($model)
    {
        $model->delete();
        return $model;
    }
}
