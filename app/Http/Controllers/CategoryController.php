<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::where('namespace', 'tag')->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $validated['namespace'] = 'tag';
        $category = Category::create($validated);
        return $category;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->assertCategoryIsValid($category);
        $validated = $request->validate($this->rules());
        $category->update($validated);
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->assertCategoryIsValid($category);
        $request = request();
        $request->validate(['password' => 'required|current_password']);
        $category->deleteThisModelPermissions();
        $category->delete();
        return $category;
    }

    /**
     * Get the validation rules.
     */
    public function rules()
    {
        return [
            'name'        => 'required|string|max:50',
            'description' => 'nullable|string|max:250',
        ];
    }

    /**
     *
     */
    public function assertCategoryIsValid(Category $category)
    {
        if ($category->namespace != 'tag')
            abort('This route should only be used for categories.');
    }
}
